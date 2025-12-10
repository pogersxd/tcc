-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 10/12/2025 às 02:23
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `streaming_musica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `album`
--

DROP TABLE IF EXISTS `album`;
CREATE TABLE IF NOT EXISTS `album` (
  `id_album` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `capa` varchar(255) NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_album`),
  KEY `id_usuario_em_album` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `album`
--

INSERT INTO `album` (`id_album`, `titulo`, `capa`, `id_usuario`) VALUES
(34, 'TOHO BOSSA NOVA 4', '24f34be7c239971f9ff41bc1300655f0.jpeg', 1),
(35, 'Abbey Road', 'c6f9fc02a5b75d95998e41494ef9f4f0.jpg', 1),
(36, 'Alucinação', '08d67e30eb8fc7aa2391f249cd48daa4.jpg', 1),
(37, 'Sgt. Pepper\'s Lonely Hearts Club Band', 'ce1140ca726b6fe8525636ab7b194447.jpg', 1),
(38, 'SEYCHELLES', 'cfd69c16ddd0ecff321bb93af1eea72b.jpg', 1),
(40, 'The Beatles', '3855d43496bd42fd536603a9fb727fef.jpg', 1),
(41, 'TOHO BOSSA NOVA 2', 'e04c78edfae5ff7edc706d595cadf78a.jpg', 1),
(42, 'TOHO BOSSA NOVA 3', '9b268111b53e7cbb260d75ad8b71ef14.jpeg', 1),
(43, 'Wish You Were Here', 'a1bce5e939c9c43f22706d33a688b29f.png', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `curtido`
--

DROP TABLE IF EXISTS `curtido`;
CREATE TABLE IF NOT EXISTS `curtido` (
  `id_curtido` int NOT NULL AUTO_INCREMENT,
  `id_item` int NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_curtido`),
  KEY `curtido_id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `curtido`
--

INSERT INTO `curtido` (`id_curtido`, `id_item`, `tipo`, `id_usuario`) VALUES
(15, 35, 'album', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `musica`
--

DROP TABLE IF EXISTS `musica`;
CREATE TABLE IF NOT EXISTS `musica` (
  `id_musica` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  `duracao` int NOT NULL,
  `detalhes` text NOT NULL,
  `id_album` int NOT NULL,
  PRIMARY KEY (`id_musica`),
  KEY `id_album_em_musica` (`id_album`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `musica`
--

INSERT INTO `musica` (`id_musica`, `titulo`, `arquivo`, `duracao`, `detalhes`, `id_album`) VALUES
(38, 'Certifique Flan.', '6d28758928107bbaa1faaa6403b0285f.mp3', 212, 'nachi', 34),
(39, 'Something', '50d0a4ca6acf5c3b01fb65f5d41a16f8.mp3', 182, 'Something in the way she moves\r\nAtracts me like no other lovers\r\nSomething in the way she woos me', 35),
(40, 'Alucinação', '2880e57f57f8d2735e525f8d5c7163e2.mp3', 294, 'Eu não estou interessado em nenhuma teoria\r\nEm nenhuma fantasia, nem no algo mais\r\nNem em tinta pro meu rosto, ou oba-oba, ou melodia\r\nPara acompanhar bocejos, sonhos matinais\r\n\r\nEu não estou interessado em nenhuma teoria\r\nNem nessas coisas do Oriente, romances astrais\r\nA minha alucinação é suportar o dia a dia\r\nE meu delírio é a experiência com coisas reais\r\n\r\nUm preto, um pobre, um estudante, uma mulher sozinha\r\nBlue jeans e motocicletas, pessoas cinzas normais\r\nGarotas dentro da noite, revólver, cheira a cachorro\r\nOs humilhados do parque com os seus jornais\r\n\r\nCarneiros, mesa, trabalho, meu corpo que cai do oitavo andar\r\nE a solidão das pessoas dessas capitais\r\nA violência da noite, o movimento do tráfego\r\nUm rapaz delicado e alegre que canta e requebra, é demais\r\nCravos, espinhas no rosto, rock, hot dog, play it cool, baby\r\nDoze jovens coloridos, dois policiais\r\n\r\nCumprindo o seu duro dever\r\nE defendendo o seu amor\r\nE nossa vida\r\nCumprindo o seu duro dever\r\nE defendendo o seu amor\r\nE nossa vida\r\n\r\nMas eu não estou interessado em nenhuma teoria\r\nEm nenhuma fantasia, nem no algo mais\r\nLonge, o profeta do terror que a Laranja Mecânica anuncia\r\nAmar e mudar as coisas me interessa mais\r\n\r\nAmar e mudar as coisas\r\nAmar e mudar as coisas me interessa mais\r\n\r\nUm preto, um pobre, um estudante, uma mulher sozinha\r\nBlue jeans e motocicletas, pessoas cinzas normais\r\nGarotas dentro da noite, revólver, cheira a cachorro\r\nOs humilhados do parque com os seus jornais\r\n\r\nCarneiros, mesa, trabalho, meu corpo que cai do oitavo andar\r\nE a solidão das pessoas dessas capitais\r\nA violência da noite, o movimento do tráfego\r\nUm rapaz delicado e alegre que canta e requebra, é demais\r\nCravos, espinhas no rosto, rock, hot dog, play it cool, baby\r\nDoze jovens coloridos, dois policiais\r\n\r\nCumprindo o seu duro dever\r\nE defendendo o seu amor\r\nE nossa vida\r\nCumprindo o seu duro dever\r\nE defendendo o seu amor\r\nE nossa vida\r\n\r\nMas eu não estou interessado em nenhuma teoria\r\nEm nenhuma fantasia, nem no algo mais\r\nLonge, o profeta do terror que a Laranja Mecânica anuncia\r\nAmar e mudar as coisas me interessa mais\r\n\r\nAmar e mudar as coisas\r\nAmar e mudar as coisas me interessa mais', 36),
(41, 'I Want You (She\'s So Heavy)', '339a0f63e2c8de6655fee0d21a01d627.mp3', 467, 'I want you, I want you so bad\r\nI want you, I want you so bad\r\nIt\'s driving me mad, it\'s driving me mad\r\n\r\nI want you, I want you so bad, babe\r\nI want you, I want you so bad\r\nIt\'s driving me mad, it\'s driving me\r\n\r\nI want you, I want you so bad, babe\r\nI want you, I want you so bad\r\nIt\'s driving me mad, it\'s driving me bad\r\n\r\nI want you, I want you so bad\r\nI want you, I want you so bad\r\nIt\'s driving me mad, it\'s driving me\r\n\r\nShe\'s so heavy\r\nHeavy (heavy, heavy)\r\n\r\nShe\'s so heavy\r\nShe\'s so heavy (heavy, heavy)\r\n\r\nI want you, I want you so bad\r\nI want you, I want you so bad\r\nIt\'s driving me mad, it\'s driving me mad\r\n\r\nI want you, you know I want you so bad, babe\r\nI want you, you know I want you so bad\r\nIt\'s driving me mad, it\'s driving me mad\r\n\r\nYeah!\r\n\r\nShe\'s so', 35),
(42, 'Sgt. Pepper\'s Lonely Hearts Club Band', '67c549224a4fc834d7f445284e151c49.mp3', 122, 'It was twenty years ago today\r\nSergeant Pepper taught the band to play\r\nThey\'ve been going in and out of style\r\nBut they\'re guaranteed to raise a smile\r\n\r\nSo may I introduce to you\r\nThe act you\'ve known for all these years\r\nSergeant Pepper\'s Lonely Hearts Club Band\r\n\r\nWe\'re Sergeant Pepper\'s Lonely Hearts Club Band\r\nWe hope you will enjoy the show\r\nSergeant Pepper\'s Lonely Hearts Club Band\r\nSit back and let the evening go\r\n\r\nSergeant Pepper\'s Lonely\r\nSergeant Pepper\'s Lonely\r\nSergeant Pepper\'s Lonely Hearts Club Band\r\n\r\nIt\'s wonderful to be here\r\nIt\'s certainly a thrill\r\nYou\'re such a lovely audience\r\nWe\'d like to take you home with us\r\nWe\'d love to take you home\r\n\r\nI don\'t really want to stop the show\r\nBut I thought you might like to know\r\nThat the singer\'s going to sing a song\r\nAnd he wants you all to sing along\r\nSo let me introduce to you\r\nThe one and only Billy Shears\r\nAnd Sergeant Pepper\'s Lonely Hearts Club Band', 37),
(43, 'She\'s Leaving Home', 'c9d7c70622b036664fad18c3ac4c4a3c.mp3', 215, 'Wednesday morning at five o\'clock\r\nAs the day begins\r\nSilently closing her bedroom door\r\nLeaving the note that she hoped would say more\r\n\r\nShe goes downstairs to the kitchen\r\nClutching her handkerchief\r\nQuietly turning the backdoor key\r\nStepping outside, she is free\r\n\r\nShe\r\n(We gave her most of our lives)\r\nIs leaving\r\n(Sacrified most of our lives)\r\nHome\r\n(We gave her everything money could buy)\r\nShe\'s leaving home after living alone (bye, bye)\r\nFor so many years\r\n\r\nFather snores as his wife gets into\r\nHer dressing gown\r\nPicks up the letter that\'s lying there\r\nStanding alone at the top of the stairs\r\n\r\nShe breaks down and cries to her husband\r\nDaddy, our baby is gone\r\nWhy would she treat us so thoughtlessly?\r\nHow could she do this to me?\r\n\r\nShe\r\n(We never thought of ourselves)\r\nIs leaving\r\n(Never a thought for ourselves)\r\nHome\r\n(We struggled hard all our lives to get by)\r\nShe\'s leaving home after living alone (bye, bye)\r\nFor so many years\r\n\r\nFriday morning, at nine o\'clock\r\nShe is far away\r\nWaiting to keep the appointment she made\r\nMeeting a man from the motor trade\r\n\r\nShe\r\n(What did we do that was wrong?)\r\nIs having\r\n(We didn\'t know it was wrong)\r\nFun\r\n(Fun is the one thing that money can\'t buy)\r\nSomething inside that was always denied (bye, bye)\r\nFor so many years\r\n\r\nShe\'s leaving home\r\nBye, bye', 37),
(44, 'A Day In The Life', '72e5c8b580463c5cf001d4c6f47eede6.mp3', 337, 'I read the news today, oh, boy\r\nAbout a lucky man who made the grade\r\nAnd though the news was rather sad\r\nWell, I just had to laugh\r\nI saw the photograph\r\n\r\nHe blew his mind out in a car\r\nHe didn\'t notice that the lights had changed\r\nA crowd of people stood and stared\r\nThey\'d seen his face before\r\nNobody was really sure if he was from the House of Lords\r\n\r\nI saw a film today, oh, boy\r\nThe English Army had just won the war\r\nA crowd of people turned away\r\nBut I just had to look\r\nHaving read the book\r\nI\'d love to turn you on\r\n\r\nWoke up, fell out of bed\r\nDragged a comb across my head\r\nFound my way downstairs and drank a cup\r\nAnd looking up, I noticed I was late\r\n\r\nFound my coat and grabbed my hat\r\nMade the bus in seconds flat\r\nFound my way upstairs and had a smoke\r\nAnd somebody spoke, and I went into a dream\r\n(Aah, aah, aah, aah)\r\n\r\nI read the news today, oh, boy\r\nFour thousand holes in Blackburn, Lancashire\r\nAnd though the holes were rather small\r\nThey had to count them all\r\nNow they know how many holes it takes to fill the Albert Hall\r\nI\'d love to turn you on', 37),
(45, 'トーキョー レギー', '178ed1ac6e137424204b361e34cac869.mp3', 265, '[Chorus]\r\nNatsu ga mata kuru itsuka no melody\r\nHashiru kaze ni nori kokoro hazuma se\r\nGoran yo futari no yume sae koe o hisomete\r\nSoko made kite iru no sa\r\n\r\n[Verse 1]\r\nKirakira nemuri wa kimamana melody\r\nUtsurautsura to boku o sugite yuku\r\nMe o hosome kimi o miagete miru\r\nUmi no uta doko ka de kikoete kuru\r\n\r\n[Chorus]\r\nNatsu ga mata kuru itsuka no melody\r\nHashiru kaze ni nori kokoro hazuma se\r\nGoran yo futari no yume sae koe o hisomete\r\nSoko made kite iru no sa', 38),
(47, 'Fotografia 3 X 4', 'c3828010baecb04ab8a7f24c12c4076a.mp3', 323, 'Eu me lembro muito bem do dia que eu cheguei\r\nJovem que desce do norte pra cidade grande\r\nOs pés cansados e feridos de andar légua tirana\r\nDe lágrimas nos olhos de ler o Pessoa\r\nE de ver o verde da cana\r\n\r\nEm cada esquina que eu passava, um guarda me parava\r\nPedia os meus documentos e depois sorria\r\nExaminando o 3X4 da fotografia\r\nE estranhando o nome do lugar de onde eu vinha\r\n\r\nPois o que pesa no norte, pela Lei da Gravidade\r\nDisso Newton já sabia, cai no sul, grande cidade\r\nSão Paulo violento, corre o rio que me engana\r\nCopacabana, zona norte e os cabarés\r\nDa Lapa onde eu morei\r\n\r\nMesmo vivendo assim, não me esqueci de amar\r\nQue o homem é pra mulher, e o coração pra gente dar\r\nMas a mulher, a mulher que eu amei\r\nNão pôde me seguir, não\r\n\r\nDesses casos de família e de dinheiro eu nunca entendi bem\r\nVeloso, o Sol não é tão bonito pra quem vem do norte e vai viver na rua\r\n\r\nA noite fria me ensinou a amar mais o meu dia\r\nE pela dor eu descobri o poder da alegria\r\nE a certeza de que tenho coisas novas\r\nCoisas novas pra dizer\r\n\r\nA minha história é talvez, é talvez igual à tua\r\nJovem que desceu do norte, que no sul viveu na rua\r\nE que ficou desnorteado\r\nComo é comum no seu tempo\r\nE que ficou desapontado\r\nComo é comum no seu tempo\r\nE que ficou apaixonado e violento\r\nComo, como você\r\n\r\nA minha história é talvez, é talvez igual à tua\r\nJovem que desceu do norte, que no sul viveu na rua\r\nE que ficou desnorteado\r\nComo é comum no seu tempo\r\nE que ficou desapontado\r\nComo é comum no seu tempo\r\nE que ficou apaixonado e violento\r\nComo, como você\r\n\r\nEu sou como você\r\nEu sou como você\r\nEu sou como você\r\nQue me ouve agora\r\nEu, eu sou como você\r\nEu sou como você\r\nEu sou como você\r\nEu sou como você\r\nEu sou como você\r\nEu sou como você', 36),
(48, 'Sujeito De Sorte', 'ce9f1b3f883fdc9d5efeeb01a99c0132.mp3', 197, 'Presentemente, eu posso me\r\nConsiderar um sujeito de sorte\r\nPorque apesar de muito moço\r\nMe sinto são, e salvo, e forte\r\nE tenho comigo pensado\r\nDeus é brasileiro e anda do meu lado\r\nE assim já não posso sofrer no ano passado\r\n\r\nTenho sangrado demais\r\nTenho chorado pra cachorro\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\nTenho sangrado demais\r\nTenho chorado pra cachorro\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\n\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\n\r\nPresentemente, eu posso me\r\nConsiderar um sujeito de sorte\r\nPorque apesar de muito moço\r\nMe sinto são, e salvo, e forte\r\nE tenho comigo pensado\r\nDeus é brasileiro e anda do meu lado\r\nE assim já não posso sofrer no ano passado\r\n\r\nTenho sangrado demais\r\nTenho chorado pra cachorro\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\nTenho sangrado demais\r\nTenho chorado pra cachorro\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\n\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\n\r\nPresentemente, eu posso me\r\nConsiderar um sujeito de sorte\r\nPorque apesar de muito moço\r\nMe sinto são, e salvo, e forte\r\nE tenho comigo pensado\r\nDeus é brasileiro e anda do meu lado\r\nE assim já não posso sofrer no ano passado\r\n\r\nTenho sangrado demais\r\nTenho chorado pra cachorro\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\nTenho sangrado demais\r\nTenho chorado pra cachorro\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\n\r\nAno passado eu morri\r\nMas esse ano eu não morro\r\nAno passado eu morri\r\nMas esse ano eu não morro', 36),
(49, 'Velha Roupa Colorida', 'ea6b7816400e9bf737445fee4983c9de.mp3', 290, 'Você não sente nem vê, mas eu não posso deixar de dizer, meu amigo\r\nQue uma nova mudança em breve vai acontecer\r\nE o que há algum tempo era jovem e novo, hoje é antigo\r\nE precisamos todos rejuvenescer\r\n\r\nNunca mais meu pai falou: She\'s leaving home\r\nE meteu o pé na estrada, like a rolling stone\r\nNunca mais eu convidei minha menina\r\nPara correr no meu carro\r\nLoucura, chiclete e som\r\n\r\nNunca mais você saiu à rua em grupo reunido\r\nO dedo em V, cabelo ao vento\r\nAmor e flor, quêde o cartaz?\r\nNo presente, a mente, o corpo é diferente\r\nE o passado é uma roupa que não nos serve mais\r\nNo presente, a mente, o corpo é diferente\r\nE o passado é uma roupa que não nos serve mais\r\n\r\nVocê não sente nem vê, mas eu não posso deixar de dizer, meu amigo\r\nQue uma nova mudança em breve vai acontecer\r\nE o que há algum tempo era jovem e novo, hoje é antigo\r\nE precisamos todos rejuvenescer\r\n\r\nComo Poe, poeta louco americano\r\nEu pergunto ao passarinho\r\nBlack bird, assum-preto, o que se faz?\r\nE raven, never, raven, never, raven\r\nNever, raven, never, raven\r\nAssum-preto, pássaro-preto, black bird, me responde\r\nTudo já ficou atrás\r\nE raven, never, raven, never, raven\r\nNever, raven, never, raven\r\nBlack bird, assum-preto, pássaro-preto, me responde\r\nO passado nunca mais\r\n\r\nVocê não sente nem vê, mas eu não posso deixar de dizer, meu amigo\r\nQue uma nova mudança em breve vai acontecer\r\nE o que há algum tempo era jovem e novo, hoje é antigo\r\nE precisamos todos rejuvenescer\r\nE precisamos todos rejuvenescer\r\nE precisamos todos rejuvenescer', 36),
(50, 'Apenas Um Rapaz Latino Americano', '27266be60b74ffabaaec033357900442.mp3', 258, 'Eu sou apenas um rapaz\r\nLatino-americano, sem dinheiro no banco\r\nSem parentes importantes\r\nE vindo do interior\r\n\r\nMas trago de cabeça uma canção do rádio\r\nEm que um antigo compositor baiano me dizia\r\nTudo é divino\r\nTudo é maravilhoso\r\n\r\nMas trago de cabeça uma canção do rádio\r\nEm que um antigo compositor baiano me dizia\r\nTudo é divino\r\nTudo é maravilhoso\r\n\r\nTenho ouvido muitos discos, conversado com pessoas\r\nCaminhado meu caminho, papo, som, dentro da noite\r\nE não tenho um amigo sequer\r\nQue inda acredite nisso, não, tudo muda\r\nE com toda razão\r\n\r\nEu sou apenas um rapaz\r\nLatino-americano, sem dinheiro no banco\r\nSem parentes importantes\r\nE vindo do interior\r\n\r\nMas sei que tudo é proibido\r\nAliás, eu queria dizer que tudo é permitido\r\nAté beijar você no escuro do cinema\r\nQuando ninguém nos vê\r\n\r\nMas sei que tudo é proibido\r\nAliás, eu queria dizer que tudo é permitido\r\nAté beijar você no escuro do cinema\r\nQuando ninguém nos vê\r\n\r\nNão me peça que eu lhe faça uma canção como se deve\r\nCorreta, branca, suave, muito limpa, muito leve\r\nSons, palavras, são navalhas\r\nE eu não posso cantar como convém\r\nSem querer ferir ninguém\r\n\r\nMas não se preocupe, meu amigo\r\nCom os horrores que eu lhe digo\r\nIsto é somente uma canção\r\nA vida realmente é diferente, quer dizer\r\nAo vivo é muito pior\r\n\r\nE eu sou apenas um rapaz\r\nLatino-americano, sem dinheiro no banco\r\nPor favor, não saque a arma no saloon\r\nEu sou apenas o cantor\r\n\r\nMas, se depois de cantar\r\nVocê ainda quiser me atirar\r\nMate-me logo, à tarde, às três\r\nQue à noite eu tenho um compromisso e não posso faltar\r\nPor causa de vocês\r\n\r\nMas, se depois de cantar\r\nVocê ainda quiser me atirar\r\nMate-me logo, à tarde, às três\r\nQue à noite eu tenho um compromisso e não posso faltar\r\nPor causa de vocês\r\n\r\nEu sou apenas um rapaz\r\nLatino-americano, sem dinheiro no banco\r\nSem parentes importantes\r\nE vindo do interior\r\n\r\nMas sei que nada é divino\r\nNada, nada é maravilhoso\r\nNada, nada é secreto\r\nNada, nada é misterioso, não', 36),
(51, 'Como Nossos Pais', 'a66e7e8295c64e77734951fee46b0b59.mp3', 280, 'Não quero lhe falar, meu grande amor\r\nDas coisas que aprendi nos discos\r\nQuero lhe contar como eu vivi\r\nE tudo o que aconteceu comigo\r\n\r\nViver é melhor que sonhar\r\nE eu sei que o amor é uma coisa boa\r\nMas também sei que qualquer canto é menor do que a vida\r\nDe qualquer pessoa\r\n\r\nPor isso, cuidado, meu bem\r\nHá perigo na esquina\r\nEles venceram\r\nE o sinal está fechado pra nós que somos jovens\r\nPara abraçar meu irmão e beijar minha menina na rua\r\nÉ que se fez o meu lábio, o meu braço e a minha voz\r\n\r\nVocê me pergunta pela minha paixão\r\nDigo que estou encantado como uma nova invenção\r\nVou ficar nesta cidade, não, não vou voltar pro sertão\r\nPois vejo vir vindo no vento um cheiro da nova estação\r\nE eu sei de tudo na ferida viva do meu coração\r\n\r\nJá faz tempo, eu vi você na rua\r\nCabelo ao vento, gente jovem reunida\r\nNa parede da memória\r\nEsta lembrança é o quadro que dói mais\r\n\r\nMinha dor é perceber\r\nQue apesar de termos feito\r\nTudo, tudo o que fizemos\r\nAinda somos os mesmos e vivemos\r\nAinda somos os mesmos e vivemos como os nossos pais\r\n\r\nNossos ídolos ainda são os mesmos\r\nE as aparências, as aparências não enganam, não\r\nVocê diz que depois deles\r\nNão apareceu mais ninguém\r\n\r\nVocê pode até dizer que eu estou por fora\r\nOu então que eu estou inventando\r\nMas é você que ama o passado e que não vê\r\nÉ você que ama o passado e que não vê\r\nQue o novo, o novo sempre vem\r\n\r\nE hoje eu sei que quem me deu a ideia\r\nDe uma nova consciência e juventude\r\nEstá em casa guardado por Deus\r\nContando os seus metais\r\n\r\nMinha dor é perceber que apesar de termos feito\r\nTudo, tudo o que fizemos\r\nAinda somos os mesmos e vivemos\r\nAinda somos os mesmos e vivemos\r\nAinda somos os mesmos e vivemos como os nossos pais', 36),
(52, 'OH! TENGO SUERTE', 'e3f7bac0909fe826d0f5f862d798512e.mp3', 253, 'Oh, tengo suerte!\r\nYo compré un billete de ida para Seychelles\r\nYo compré un billete de ida para Seychelles', 38),
(53, 'While My Guitar Gently Weeps', 'e8e8b01737eea1382201196e0336a019.mp3', 285, 'I look at you all, see the love there that\'s sleeping\r\nWhile my guitar gently weeps\r\nI look at the floor and I see it needs sweeping\r\nStill my guitar gently weeps\r\n\r\nI don\'t know why nobody told you\r\nHow to unfold your love\r\nI don\'t know how someone controlled you\r\nThey bought and sold you\r\n\r\nI look at the world and I notice it\'s turning\r\nWhile my guitar gently weeps\r\nWith every mistake, we must surely be learning\r\nStill my guitar gently weeps\r\n\r\nI don\'t know how you were diverted\r\nYou were perverted too\r\nI don\'t know how you were inverted\r\nNo one alerted you\r\n\r\nI look from the wings at the play you are staging\r\nWhile my guitar gently weeps\r\nAs I\'m sitting here doing nothing but aging\r\nStill my guitar gently weeps', 40),
(54, 'Maxwell\'s Silver Hammer', '8877cd1e1ebb731cb1f773cb14ae3df6.mp3', 208, 'Joan was quizzical, studied pataphysical\r\nScience in the home\r\nLate nights all alone with a test tube\r\nOh, oh, oh, oh\r\n\r\nMaxwell Edison, majoring in medicine\r\nCalls her on the phone\r\nCan I take you out to the pictures\r\nJoa, oa, oa, oan?\r\n\r\nBut as she\'s getting ready to go\r\nA knock comes on the door\r\n\r\nBang! Bang! Maxwell\'s silver hammer\r\nCame down upon her head\r\nClang! Clang! Maxwell\'s silver hammer\r\nMade sure that she was dead\r\n\r\nBack in school again, Maxwell plays the fool again\r\nTeacher gets annoyed\r\nWishing to avoid an unpleasant\r\nSce, e, e, ene\r\n\r\nShe tells Max to stay when the class has gone away\r\nSo he waits behind\r\nWriting fifty times: I must not be\r\nSo-o-o\r\n\r\nBut when she turns her back on the boy\r\nHe creeps up from behind\r\n\r\nBang! Bang! Maxwell\'s silver hammer\r\nCame down upon her head (do, do, do, do)\r\nClang! Clang! Maxwell\'s silver hammer\r\nMade sure that she was dead\r\n\r\nP.C. thirty-one said: We caught a dirty one\r\nMaxwell stands alone\r\nPainting testimonial pictures\r\nOh, oh, oh, oh\r\n\r\nRose and Valerie, screaming from the gallery\r\nSay he must go free (Maxwell must go free)\r\nThe judge does not agree and he tells them\r\nSo, o, o, o\r\n\r\nBut as the words are leaving his lips\r\nA noise comes from behind\r\n\r\nBang! Bang! Maxwell\'s silver hammer\r\nCame down upon his head\r\nClang! Clang! Maxwell\'s silver hammer\r\nMade sure that he was dead\r\n\r\nWhoa, oh, oh, oh\r\nSilver hammer man', 35),
(56, 'タイニーリトル・アジアンタム', '2cf1b169a1d7fb5e91b9db86c1cef2ff.mp3', 351, 'Kinou mama ga yonde kureta otogibanashi wa\r\nOhimesama to oujisama ga\r\nShiawase na kisu wo shitan da kedo\r\nWatashi mada amai koi zenzen wakannakute\r\nYume wo mita no yume wo miru no\r\nDaisuki na jinjaabureddo no koto\r\nKare wa pekori to ojigi shite watashi ni kiita\r\n\"Doko e yuku no?\" \"Nani wo suru no?\"\r\nWatashi nani mo ienakute naita no\r\nUtsumuita kono odeko tonton tataita no wa\r\nKimi nano kana? chigau no kana?\r\nMe wo aketai no ni mada kowain da\r\n\r\nYuuyake tte nan da ka samishii\r\nOnegai, matte\r\nMou sugu motto motto yobu kara\r\nAtarimae mitai na kotoba nante yamete yo\r\nDatte hoshii no, honto no kimochi dake\r\nMada, mada, kodomo datte iun desho\r\nWakatteru no kawaritai no dakedo ne\r\nSotto sotto oshiete\r\nAtarashii sekai no kagi mawashite\r\nSenaka wo dakishimetai, nante ne\r\nChotto osanai tte shitteru mon\r\n\r\nFuwa fuwa sora ni ukabu kyandi potto\r\nKumo no oshiro de odorou\r\nMahou wo chotto dake kaketara\r\nOujisama ni aeru no\r\n\r\nYume miteru koto shitteru yo\r\nDemo kimi ga honto ni oujisama datta nara\r\nKitto doresu mo garasu no kutsu mo\r\nSuki ni nareru hazu nano\r\n\r\nNee, kimi ga mou ichido warattara\r\nKondo wa kitto watashi mo wakaru ki ga suru no\r\nDorippu shita koohii wa mada nigai\r\nOsatou chotto tokashite nondara ieru kana\r\nNee, mama mitai ni kirei ni\r\nNareru no kana wakannai na dakara ne\r\nRippu wa gurosu dake\r\nUsui kuchibiru nante suki ja nai kana…\r\nDou sureba ii no?\r\nDatte, mou, kimi no ijiwaru na koe ga suru', 41),
(57, 'ナルキッソスにさよなら', '1fe2d9dfe0db9dda4bf5da42d2e9915c.mp3', 191, 'yoake mae wa awai kodama\r\nshiawase na uta hibikidasu no\r\nkomorebi ni ame harema ni wa tsuyukusa\r\nmada soko ni iru no?\r\nkaze dake ga\r\nyureru\r\n\r\nsagashimono wa nāni\r\nmori no kakurega ni mo\r\ndoko ni mo nai no\r\n\r\nsaita hana no michi ni mō\r\nashidori tsukamenai\r\n\r\nc\'est la vie, mais Je veux te voir...\r\n\r\nhōseki bako ni kakushite ita\r\ntaisetsu na akai ame ano ko ni\r\ntaberareta wa\r\n\r\nnaisho no koi ni irozuiteku kako mo\r\nmirai mo zenbu\r\nano ko no ichizu na ashioto o kakusu no\r\nc\'est la vie, mais Je veux te voir...\r\n\r\n\r\nsoshite shizuka na jikan ga\r\nmune o kusuguru yō ni\r\nla la la la...\r\nla la la la...\r\n\r\nmimi ni nokoru osanai koe wa\r\nhito-tsu kiri no koi o\r\nutau no\r\nJe veux te voir...\r\n\r\nla la la la la---', 41),
(58, 'Garota de venda medicamento', 'c759693558496311df15240e22a48894.mp3', 246, 'babababa', 42),
(59, 'Que ela vem', '75309519d05b795deac1fe9c4de26182.mp3', 128, 'bolo', 42),
(60, 'Wish You Were Here', '8068f9b27cb7f04507ca0aa665868cd4.mp3', 335, 'So, so you think you can tell\r\nHeaven from hell?\r\nBlue skies from pain?\r\nCan you tell a green field\r\nFrom a cold steel rail?\r\nA smile from a veil?\r\nDo you think you can tell?\r\n\r\nDid they get you to trade\r\nYour heroes for ghosts?\r\nHot ashes for trees?\r\nHot air for a cool breeze?\r\nCold comfort for change?\r\nDid you exchange\r\nA walk on part in the war\r\nFor a lead role in a cage?\r\n\r\nHow I wish\r\nHow I wish you were here\r\nWe\'re just two lost souls\r\nSwimming in a fish bowl year after year\r\nRunning over the same old ground\r\nWhat have we found?\r\nThe same old fears\r\nWish you were here', 43);

-- --------------------------------------------------------

--
-- Estrutura para tabela `musica_playlist`
--

DROP TABLE IF EXISTS `musica_playlist`;
CREATE TABLE IF NOT EXISTS `musica_playlist` (
  `id_playlist` int NOT NULL,
  `id_musica` int NOT NULL,
  `id_musicaplaylist` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_musicaplaylist`),
  KEY `id_musica_em_conexao_playlist` (`id_musica`),
  KEY `id_playlist_em_conexao_playlist` (`id_playlist`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `musica_playlist`
--

INSERT INTO `musica_playlist` (`id_playlist`, `id_musica`, `id_musicaplaylist`) VALUES
(1, 39, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `playlist`
--

DROP TABLE IF EXISTS `playlist`;
CREATE TABLE IF NOT EXISTS `playlist` (
  `id_playlist` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `capa` varchar(255) NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_playlist`),
  KEY `id_usuario_em_playlist` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `playlist`
--

INSERT INTO `playlist` (`id_playlist`, `titulo`, `capa`, `id_usuario`) VALUES
(1, 'tempo', '5e4439423067b1a3aea134b9cd74452e.png', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'padrao.jpg',
  `bio` text NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `email`, `senha`, `foto`, `bio`) VALUES
(1, 'diego', 'diego@gmail.com', '$2y$10$5ycetnL9aZCiYDXosLwAquLHEYU7VTJX2Q3eNk52l9iZKIfCbN9Z.', 'padrao.jpg', ''),
(2, 'arthur', 'arthur@gmail.com', '$2y$10$FW8MPMo09vxDrNl67QIreu0.83AfDg92X.3Ef0CI9/3h4.dFDlAvq', 'padrao.jpg', ''),
(3, 'ryan gosling', 'ryan@gmail.com', '$2y$10$BeUWjiYG9w7HvNRnldtMbOG1XWaA7p1.Z2ImJZ7FNRa/rCORkBvNq', 'padrao.jpg', '');

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `id_usuario_em_album` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `curtido`
--
ALTER TABLE `curtido`
  ADD CONSTRAINT `curtido_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `musica`
--
ALTER TABLE `musica`
  ADD CONSTRAINT `id_album_em_musica` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`);

--
-- Restrições para tabelas `musica_playlist`
--
ALTER TABLE `musica_playlist`
  ADD CONSTRAINT `id_musica_em_conexao_playlist` FOREIGN KEY (`id_musica`) REFERENCES `musica` (`id_musica`),
  ADD CONSTRAINT `id_playlist_em_conexao_playlist` FOREIGN KEY (`id_playlist`) REFERENCES `playlist` (`id_playlist`);

--
-- Restrições para tabelas `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `id_usuario_em_playlist` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
