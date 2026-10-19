// Cancellation is best effort: the sequence check also rejects late responses.
class LatestRequest
{
    constructor(client)
    {
        this.client = client;
        this.sequence = 0;
        this.source = null;
    }

    cancel()
    {
        this.sequence += 1;

        if (this.source)
            this.source.cancel('Superseded request');

        this.source = null;
    }

    get(url, config = {})
    {
        this.cancel();
        const sequence = this.sequence;
        const source = this.client.CancelToken.source();
        this.source = source;

        return this.client.get(url, {...config, cancelToken: source.token})
            .then(response => sequence === this.sequence ? response : null)
            .catch(error => {
                if (sequence !== this.sequence || this.client.isCancel(error))
                    return null;

                throw error;
            })
            .finally(() => {
                if (sequence === this.sequence)
                    this.source = null;
            });
    }
}

module.exports = LatestRequest;
