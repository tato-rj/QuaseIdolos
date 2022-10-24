<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Song, Artist};

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Song::insert([
            [
                'artist_id' => Artist::byName('Legião Urbana')->id,
                'name' => 'Pais e Filhos',
                'tags' => 'rock pop 80s',
                'duration' => '3',
                'level' => 'Médio',
                'lyrics' => 'Estátuas e cofres, e paredes pintadas
Ninguém sabe o que aconteceu
Ela se jogou da janela do quinto andar
Nada é fácil de entender

Dorme agora
É só o vento lá fora

Quero colo! Vou fugir de casa
Posso dormir aqui com vocês?
Estou com medo, tive um pesadelo
Só vou voltar depois das três

Meu filho vai ter nome de santo
Quero o nome mais bonito

É preciso amar as pessoas
Como se não houvesse amanhã
Porque se você parar pra pensar
Na verdade, não há

Me diz, por que que o céu é azul?
Explica a grande fúria do mundo
São meus filhos
Que tomam conta de mim

Eu moro com a minha mãe
Mas meu pai vem me visitar
Eu moro na rua, não tenho ninguém
Eu moro em qualquer lugar

Já morei em tanta casa
Que nem me lembro mais
Eu moro com meus pais

É preciso amar as pessoas
Como se não houvesse amanhã
Porque se você parar pra pensar
Na verdade, não há

Sou uma gota d\'água
Sou um grão de areia
Você me diz que seus pais não o entendem
Mas você não entende seus pais

Você culpa seus pais por tudo, isso é um absurdo
São crianças como você
O que você vai ser
Quando você crescer?'
            ]
        ]);

        Song::insert([
            [
                'artist_id' => Artist::byName('Legião Urbana')->id,
                'name' => 'Meninos e Meninas',
                'tags' => 'rock pop 80s',
                'duration' => '6',
                'level' => 'Fácil',
                'lyrics' => 'Quero me encontrar, mas não sei onde estou
Vem comigo procurar algum lugar mais calmo
Longe dessa confusão e dessa gente que não se respeita
Tenho quase certeza que eu não sou daqui

Acho que gosto de São Paulo e gosto de São João
Gosto de São Francisco e São Sebastião
E eu gosto de meninos e meninas

Vai ver que é assim mesmo e vai ser assim pra sempre
Vai ficando complicado e ao mesmo tempo diferente
Estou cansado de bater e ninguém abrir
Você me deixou sentindo tanto frio
Não sei mais o que dizer

Te fiz comida, velei teu sono
Fui teu amigo, te levei comigo
E me diz: pra mim o que é que ficou?

Me deixa ver como viver é bom
Não é a vida como está, e sim as coisas como são
Você não quis tentar me ajudar
Então, a culpa é de quem? A culpa é de quem?

Eu canto em português errado
Acho que o imperfeito não participa do passado
Troco as pessoas, troco os pronomes

Preciso de oxigênio, preciso ter amigos
Preciso ter dinheiro, preciso de carinho
Acho que te amava, agora acho que te odeio
São tudo pequenas coisas e tudo deve passar

Acho que gosto de São Paulo e gosto de São João
Gosto de São Francisco e São Sebastião
E eu gosto de meninos e meninas'
            ]
        ]);

        Song::insert([
            [
                'artist_id' => Artist::byName('Legião Urbana')->id,
                'name' => 'Geração Coca-Cola',
                'tags' => 'rock pop 80s',
                'duration' => '4',
                'level' => 'Fácil',
                'lyrics' => 'Quando nascemos fomos programados
A receber o que vocês
Nos empurraram com os enlatados
Dos U.S.A., de nove às seis

Desde pequenos nós comemos lixo
Comercial e industrial
Mas agora chegou nossa vez
Vamos cuspir de volta o lixo em cima de vocês

Somos os filhos da revolução
Somos burgueses sem religião
Somos o futuro da nação
Geração Coca-Cola

Depois de 20 anos na escola
Não é difícil aprender
Todas as manhas do seu jogo sujo
Não é assim que tem que ser

Vamos fazer nosso dever de casa
E aí então vocês vão ver
Suas crianças derrubando reis
Fazer comédia no cinema com as suas leis

Somos os filhos da revolução
Somos burgueses sem religião
Somos o futuro da nação
Geração Coca-Cola
Geração Coca-Cola
Geração Coca-Cola
Geração Coca-Cola

Depois de 20 anos na escola
Não é difícil aprender
Todas as manhas do seu jogo sujo
Não é assim que tem que ser

Vamos fazer nosso dever de casa
E aí então vocês vão ver
Suas crianças derrubando reis
Fazer comédia no cinema com as suas leis

Somos os filhos da revolução
Somos burgueses sem religião
Somos o futuro da nação
Geração Coca-cola
Geração Coca-cola
Geração Coca-cola
Geração Coca-cola'
            ]
        ]);

        Song::insert([
            [
                'artist_id' => Artist::byName('Legião Urbana')->id,
                'name' => 'Ainda é Cedo',
                'tags' => 'rock pop 80s',
                'duration' => '5',
                'level' => 'Fácil',
                'lyrics' => 'Uma menina me ensinou
Quase tudo que eu sei
Era quase escravidão
Mas ela me tratava como um rei

Ela fazia muitos planos
Eu só queria estar ali
Sempre ao lado dela
Eu não tinha aonde ir

Mas egoísta que eu sou
Me esqueci de ajudar
A ela como ela me ajudou
E não quis me separar

Ela também estava perdida
E por isso se agarrava a mim também
E eu me agarrava a ela
Porque eu não tinha mais ninguém

E eu dizia ainda é cedo
Cedo, cedo, cedo, cedo
E eu dizia ainda é cedo
Cedo, cedo, cedo, cedo
Ah, eu dizia ainda é cedo
Cedo, cedo, cedo, cedo
Ah, eu dizia ainda é cedo

Sei que ela terminou
O que eu não comecei
E o que ela descobriu
Eu aprendi também, eu sei

Ela falou: Você tem medo
Aí eu disse: Quem tem medo é você
Falamos o que não devia
Nunca ser dito por ninguém

Ela me disse: Eu não sei
Mais o que eu sinto por você
Vamos dar um tempo
Um dia a gente se vê

E eu dizia ainda é cedo
Cedo, cedo, cedo, cedo
E eu dizia ainda é cedo
Cedo, cedo, cedo, cedo
Ah, eu dizia ainda é cedo
Cedo, cedo, cedo, cedo
Ah, eu dizia ainda é cedo.'
            ]
        ]);

        Song::insert([
            [
                'artist_id' => Artist::byName('Babado Novo')->id,
                'name' => 'Amor Perfeito',
                'tags' => 'axe 2000s',
                'duration' => '3',
                'level' => 'Difícil',
                'lyrics' => 'Fecho os olhos pra não ver passar o tempo
Sinto falta de você
Anjo bom, amor perfeito no meu peito
Sem você não sei viver

Então vem
Que eu conto os dias, conto as horas pra te ver
Eu não consigo te esquecer
Cada minuto é muito tempo sem você, sem você

Os segundos vão passando lentamente
Não têm hora pra chegar
Até quando te amando, te querendo
Coração quer te encontrar

Então vem
Que nos teus braços esse amor é uma canção
Eu não consigo te esquecer
Cada minuto é muito tempo sem você, sem você

Eu não vou saber me acostumar
Sem suas mãos pra me acalmar
Sem seu olhar pra me entender
Sem seu carinho, amor, sem você
Vem me tirar da solidão
Fazer feliz meu coração
Já não importa quem errou
O que passou, passou

Então vem
Que eu conto os dias conto as horas pra te ver
Eu não consigo te esquecer
Cada minuto é muito tempo sem você, sem você

Fecho os olhos pra não ver passar o tempo
Sinto falta de você
Anjo bom, amor perfeito no meu peito
Sem você não sei viver

Então vem
Que eu conto os dias, conto as horas pra te ver
Eu não consigo te esquecer
Cada minuto é muito tempo sem você, sem você

Os segundos vão passando lentamente
Não têm hora pra chegar
Anjo bom, amor perfeito no meu peito
Coração quer te encontrar

Então vem
Que nos meus braços, esse amor é uma canção
Eu não consigo te esquecer
Cada minuto é muito tempo sem você, sem você

Eu não vou saber me acostumar
Sem suas mãos pra me acalmar
Sem seu olhar pra me entender
Sem seu carinho, amor, sem você
Vem me tirar da solidão
Fazer feliz meu coração
Já não importa quem errou
O que passou, passou

Então vem
Que eu conto os dias, conto as horas pra te ver
Eu não consigo te esquecer
Cada minuto é muito tempo sem você, sem você'
            ]
        ]);

        Song::insert([
            [
                'artist_id' => Artist::byName('Babado Novo')->id,
                'name' => 'Bola de Sabão',
                'tags' => 'axe 2000s',
                'duration' => '4',
                'level' => 'Médio',
                'lyrics' => 'Baby! Baby!
Queria tanto te ver
Vê se me liga às vezes
Só para dizer um "oi"
Talvez quem sabe
Não seja assim tão tarde
Queria ter uma nave
Prá te levar
Prá dar um rolé...

Nas nuvens!
E te vestir com a luz do sol
Te beijar infinito
Admirar as suas asas...

Anjo!
Venha voar só no meu céu
Me pegue no teu colo
Que eu viajo
Além do horizonte...
(Hê! Hê!)

Pirou!
Minha cabeça
E o coração
Feito bola de sabão
Me desmancho por você...(2x)
(Hê! Hê! Hê!)

Baby! Baby!
Queria tanto te ver
Vê se me liga às vezes
Só prá dizer um "oi"
Talvez quem sabe
Não seja assim tão tarde
Queria ter uma nave
Prá te levar
Prá dar um rolé...

Nas nuvens!
E te vestir com a luz do sol
Te beijar infinito
Admirar as suas asas...

Anjo!
Venha voar só no meu céu
Me pegue no teu colo
Que eu viajo
Além do horizonte...
(Hê! Hê!)

Pirou!
Minha cabeça
E o coração
Feito bola de sabão
Me desmancho por você...(2x)
(Hê! Hê! Hê! Hê!)

Oh! Oh! Oh! Oh! Oh Oh!
Oh! Oh! Oh! Oh! Oh Oh!
Oh! Oh! Oh! Oh! Oh Oh!...(2x)
(Hê! Hê!)

Nas nuvens!
E te vestir com a luz do sol
Te beijar infinito
Admirar as suas asas...

Anjo!
Venha voar só no meu céu
Me pegue no teu colo
Que eu viajo
Além do horizonte...
(Hê! Hê!)

Pirou!
Minha cabeça
E o coração
Feito bola de sabão
Me desmancho por você...(4x)

Hê! Hê! Hê! Hê! Hê!...'
            ]
        ]);

        Song::insert([
            [
                'artist_id' => Artist::byName('Caetano Veloso')->id,
                'name' => 'Você é Linda',
                'tags' => 'mpb lenta 90s',
                'duration' => '3',
                'level' => 'Fácil',
                'lyrics' => 'Fonte de mel
Nos olhos de gueixa
Kabuki, máscara
Choque entre o azul
E o cacho de acácias
Luz das acácias
Você é mãe do sol

A sua coisa é toda tão certa
Beleza esperta
Você me deixa à rua deserta
Quando atravessa
E não olha pra trás

Linda
E sabe viver
Você me faz feliz
Esta canção é só pra dizer
E diz

Você é linda
Mais que demais
Você é linda sim
Onda do mar do amor
Que bateu em mim

Você é forte
Dentes e músculos
Peitos e lábios
Você é forte
Letras e músicas
Todas as músicas
Que ainda hei de ouvir

No Abaeté
Areias e estrelas
Não são mais belas
Do que você
Mulher das estrelas
Mina de estrelas
Diga o que você quer

Você é linda
E sabe viver
Você me faz feliz
Esta canção é só pra dizer
E diz

Você é linda
Mais que demais
Você é linda sim
Onda do mar do amor
Que bateu em mim

Gosto de ver
Você no seu ritmo
Dona do carnaval
Gosto de ter
Sentir seu estilo
Ir no seu íntimo
Nunca me faça mal!

Linda
Mais que demais
Você é linda sim
Onda do mar do amor
Que bateu em mim
Você é linda
E sabe viver
Você me faz feliz
Esta canção é só pra dizer
E diz'
            ]
        ]);

        Song::insert([
            [
                'artist_id' => Artist::byName('Caetano Veloso')->id,
                'name' => 'Sozinho',
                'tags' => 'mpb pop 90s',
                'duration' => '3',
                'level' => 'Fácil',
                'lyrics' => 'Às vezes, no silêncio da noite
Eu fico imaginando nós dois
Eu fico ali sonhando acordado
Juntando o antes, o agora e o depois

Por que você me deixa tão solto?
Por que você não cola em mim?
Tô me sentindo muito sozinho

Não sou nem quero ser o seu dono
É que um carinho, às vezes, cai bem
Eu tenho os meus desejos e planos secretos
Só abro pra você, mais ninguém

Por que você me esquece e some?
E se eu me interessar por alguém?
E se ela, de repente, me ganha?

Quando a gente gosta
É claro que a gente cuida
Fala que me ama
Só que é da boca pra fora

Ou você me engana
Ou não está madura
Onde está você agora?

Quando a gente gosta
É claro que a gente cuida
Fala que me ama
Só que é da boca pra fora

Ou você me engana
Ou não está madura
Onde está você agora?'
            ]
        ]);

        Song::insert([
            [
                'artist_id' => Artist::byName('Adele')->id,
                'name' => 'Rolling in the Deep',
                'tags' => 'soul pop 2010',
                'duration' => '4',
                'level' => 'Médio',
                'lyrics' => 'There\'s a fire starting in my heart
Reaching a fever pitch and it\'s bringing me out the dark
Finally, I can see you crystal clear
Go ahead and sell me out and I\'ll lay your shit bare

See how I\'ll leave with every piece of you
Don\'t underestimate the things that I will do

There\'s a fire starting in my heart
Reaching a fever pitch and it\'s bringing me out the dark

The scars of your love remind me of us
They keep me thinking that we almost had it all
The scars of your love, they leave me breathless
I can\'t help feeling

We could\'ve had it all
(You\'re gonna wish you never had met me)
Rolling in the deep
(Tears are gonna fall, rolling in the deep)
You had my heart inside of your hand
(You\'re gonna wish you never had met me)
And you played it to the beat
(Tears are gonna fall, rolling in the deep)

Baby, I have no story to be told
But I\'ve heard one of you and I\'m gonna make your head burn
Think of me in the depths of your despair
Making home down there, as mine sure won\'t be shared

(You\'re gonna wish you never had met me)
The scars of your love remind me of us
(Tears are gonna fall, rolling in the deep)
They keep me thinking that we almost had it all
(You\'re gonna wish you never had met me)
The scars of your love, they leave me breathless
(Tears are gonna fall, rolling in the deep)
I can\'t help feeling

We could\'ve had it all
(You\'re gonna wish you never had met me)
Rolling in the deep
(Tears are gonna fall, rolling in the deep)
You had my heart inside of your hand
(You\'re gonna wish you never had met me)
And you played it to the beat
(Tears are gonna fall, rolling in the deep)

We could\'ve had it all
Rolling in the deep
You had my heart inside of your hand
But you played it with a beating

Throw your soul through every open door
Count your blessings to find what you look for
Turn my sorrow into treasured gold
You pay me back in kind and reap just what you sow

(You\'re gonna wish you never had met me)
We could\'ve had it all
(Tears are gonna fall, rolling in the deep)
We could\'ve had it all
(You\'re gonna wish you never had met me)
It all, it all, it all
(Tears are gonna fall, rolling in the deep)

We could\'ve had it all
(You\'re gonna wish you never had met me)
Rolling in the deep
(Tears are gonna fall, rolling in the deep)
You had my heart inside of your hand
(You\'re gonna wish you never had met me)
And you played it to the beat
(Tears are gonna fall, rolling in the deep)

Could\'ve had it all
(You\'re gonna wish you never had met me)
Rolling in the deep
(Tears are gonna fall, rolling in the deep)
You had my heart inside of your hand
(You\'re gonna wish you never had met me)

But you played it
You played it
You played it
You played it to the beat'
            ]
        ]);
    }
}
