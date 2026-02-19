-------------------------------------------------------
-- CLEAN ALL TABLES
-------------------------------------------------------
TRUNCATE TABLE askLeic.user CASCADE;
TRUNCATE TABLE askLeic.admin CASCADE;
TRUNCATE TABLE askLeic.moderator CASCADE;
TRUNCATE TABLE askLeic.verified_user CASCADE;
TRUNCATE TABLE askLeic.question CASCADE;
TRUNCATE TABLE askLeic.tag CASCADE;
TRUNCATE TABLE askLeic.badge CASCADE;
TRUNCATE TABLE askLeic.report CASCADE;
TRUNCATE TABLE askLeic.answer CASCADE;
TRUNCATE TABLE askLeic.vote CASCADE;
TRUNCATE TABLE askLeic.notification CASCADE;
TRUNCATE TABLE askLeic.badge_notification CASCADE;
TRUNCATE TABLE askLeic.question_notification CASCADE;
TRUNCATE TABLE askLeic.answer_notification CASCADE;
TRUNCATE TABLE askLeic.awarded_badges CASCADE;
TRUNCATE TABLE askLeic.answer_to_question CASCADE;
TRUNCATE TABLE askLeic.answer_to_answer CASCADE;
TRUNCATE TABLE askLeic.user_verifies_answer CASCADE;
TRUNCATE TABLE askLeic.user_posts_answer CASCADE;
TRUNCATE TABLE askLeic.question_reports CASCADE;
TRUNCATE TABLE askLeic.answer_reports CASCADE;
TRUNCATE TABLE askLeic.question_has_tag CASCADE;
TRUNCATE TABLE askLeic.vote_on_question CASCADE;
TRUNCATE TABLE askLeic.vote_on_answer CASCADE;
TRUNCATE TABLE askLeic.user_has_notification CASCADE;

--------------------------------------------------------
--POPULATE
--------------------------------------------------------
INSERT INTO askLeic."user" (name, first_name, last_name, email, password, description, profile_picture)
VALUES 
('anaSilva', 'Ana', 'Silva', 'ana.silva@admin.com', '$2y$10$dBFeAuWUibrrLrNxntMZreqA0z46cMpFMNeMH9EnQ5oDxG0ZTgPxa', 'Estudante de L.EIC apaixonada por desenvolvimento de software.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('bruno_santos', 'Bruno', 'Santos', 'bruno.santos@example.com', 'Bruno@2024', 'Futuro engenheiro com interesse em machine learning.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('catarina.martins', 'Catarina', 'Martins', 'catarina.martins@example.com', 'C@tarina5', 'Estudante de L.EIC interessada em cibersegurança.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('diego.pereira', 'Diego', 'Pereira', 'diego.pereira@example.com', 'D!ego9876', 'Entusiasta da tecnologia focado em IoT e sistemas inteligentes.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('elena.gomes', 'Elena', 'Gomes', 'elena.gomes@example.com', 'Elena!2023', 'Estudante dedicada ao desenvolvimento web e design UI/UX.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('filipe.brito', 'Filipe', 'Brito', 'filipe.brito@moderator.com', '$2y$10$dBFeAuWUibrrLrNxntMZreqA0z46cMpFMNeMH9EnQ5oDxG0ZTgPxa', 'Focado em engenharia de software e metodologias ágeis.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('guilherme.almeida', 'Guilherme', 'Almeida', 'guilherme.almeida@example.com', 'Gui!Almeida123', 'Estudante de L.EIC com paixão por robótica e automação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('hugo.magalhães', 'Hugo', 'Magalhães', 'hugo.magalhaes@example.com', 'Hug0!Maga', 'Pensador inovador explorando a tecnologia na educação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('isabel.coelho', 'Isabel', 'Coelho', 'isabel.coelho@example.com', 'Isab3l@2023', 'Analista de dados com interesse em big data e analytics.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('joao.torres', 'João', 'Torres', 'joao.torres@example.com', 'Jo@oTorres99', 'Desenvolvedor criativo apaixonado por desenvolvimento de jogos.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('karla.souza', 'Karla', 'Souza', 'karla.souza@example.com', 'Karla$1234', 'Estudante de L.EIC focada em computação em nuvem.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('luan.silveira', 'Luan', 'Silveira', 'luan.silveira@example.com', 'Luan@Silv3', 'Entusiasta de tecnologia e aplicações em negócios.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('maria.pinto', 'Maria', 'Pinto', 'maria.pinto@example.com', 'M@riaP123', 'Estudante focada em segurança de redes e protocolos.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('nuno.lopes', 'Nuno', 'Lopes', 'nuno.lopes@example.com', 'Nuno$Lop3s', 'Entusiasta de testes de software e qualidade.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('olga.santos', 'Olga', 'Santos', 'olga.santos@example.com', 'Olga@2024', 'Estudante dedicada ao desenvolvimento de soluções inovadoras.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('paulo.costa', 'Paulo', 'Costa', 'paulo.costa@example.com', 'PauloC@2023', 'Focado em inteligência artificial e suas aplicações práticas.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('quiteria.ferreira', 'Quitéria', 'Ferreira', 'quiteria.ferreira@example.com', 'Quit3ria!', 'Entusiasta de metodologias ágeis e gestão de projetos.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('rui.teixeira', 'Rui', 'Teixeira', 'rui.teixeira@example.com', 'RuiT@ex123', 'Estudante de L.EIC com paixão por análise de dados.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('silvia.reis', 'Silvia', 'Reis', 'silvia.reis@example.com', 'SilviaR@2023', 'Desenvolvedora web focada em front-end e UX.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('tiago.nogueira', 'Tiago', 'Nogueira', 'tiago.nogueira@example.com', 'Ti@goN2024', 'Estudante interessado em sistemas de informação e gestão.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('ula.silv', 'Ula', 'Silva', 'ula.silva@example.com', 'Ula$1234', 'Fascinada por desenvolvimento sustentável e energias renováveis.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('vitor.pereira', 'Vitor', 'Pereira', 'vitor.pereira@example.com', 'Vit0rP@2023', 'Estudante de L.EIC com interesse em microeletrónica.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('wellington.s', 'Wellington', 'Silva', 'wellington.silva@example.com', 'W3llington!', 'Apresentador em eventos de tecnologia e inovação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('xenia.garcia', 'Xénia', 'García', 'xenia.garcia@example.com', 'XeN!@2024', 'Entusiasta do design gráfico e visualização de dados.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('yara.m', 'Yara', 'Mendes', 'yara.mendes@example.com', 'Yara$2023', 'Interessa-se por programação e desenvolvimento de aplicativos.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('zoe.martins', 'Zoe', 'Martins', 'zoe.martins@example.com', 'Zoe@1234', 'Focada em experiências de usuário e design de interface.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('andre.f', 'André', 'Ferreira', 'andre.ferreira@example.com', 'A!ndr3F2023', 'Estudante dedicado a soluções tecnológicas inovadoras.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('bruno.m', 'Bruno', 'Moura', 'bruno.moura@example.com', 'BrunO$@2024', 'Interesse em redes e cibersegurança.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('carla.m', 'Carla', 'Matos', 'carla.matos@example.com', 'C4rla@2023', 'Focada em ciência de dados e machine learning.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('daniel.t', 'Daniel', 'Teixeira', 'daniel.teixeira@example.com', 'D@ni3lT2023', 'Entusiasta em desenvolvimento de software ágil.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('elaine.b', 'Elaine', 'Barbosa', 'elaine.barbosa@example.com', 'El@ineB2023', 'Interesse em tecnologia educacional e desenvolvimento de apps.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('filipe.g', 'Filipe', 'Gomes', 'filipe.gomes@example.com', 'F!lipeG4$', 'Aficionado por automação e otimização de processos.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('gabriel.m', 'Gabriel', 'Melo', 'gabriel.melo@example.com', 'Gabriel$123', 'Estudante focado em desenvolvimento web e mobile.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('helena.a', 'Helena', 'Alves', 'helena.alves@example.com', 'H3lena@2023', 'Criativa e apaixonada por design e marketing digital.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('ivan.l', 'Ivan', 'Lima', 'ivan.lima@example.com', 'IvanL!@2024', 'Estudante de L.EIC com interesse em blockchain.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('joana.k', 'Joana', 'Klein', 'joana.klein@example.com', 'JoanaK!@2023', 'Interessa-se por pesquisa e inovação tecnológica.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('karl.fernandes', 'Karl', 'Fernandes', 'karl.fernandes@example.com', 'K@rlF3rn', 'Estudante em engenharia de computação e sistemas.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('luis.p', 'Luís', 'Pereira', 'luis.pereira@example.com', 'Lu!sP4@2023', 'Entusiasta em inteligência artificial e robótica.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('mariana.t', 'Mariana', 'Teixeira', 'mariana.teixeira@example.com', 'M@riana!4', 'Focada em desenvolvimento sustentável e tecnologia verde.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('nicolas.s', 'Nicolas', 'Santos', 'nicolas.santos@example.com', 'N!colasS7', 'Estudante de L.EIC com interesse em algoritmos.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('olga.n', 'Olga', 'Nunes', 'olga.nunes@example.com', '0lgaN@2023', 'Entusiasta do design digital e comunicação visual.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('pedro.b', 'Pedro', 'Barbosa', 'pedro.barbosa@example.com', 'P3dro!2023', 'Focado em desenvolvimento de software e gestão de projetos.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('quiteria.j', 'Quitéria', 'João', 'quiteria.joao@example.com', 'Quit3riaJ!', 'Interesse em big data e analytics.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('rafael.s', 'Rafael', 'Silva', 'rafael.silva@example.com', 'R@fael2023', 'Desenvolvedor com interesse em jogos eletrônicos.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('sara.c', 'Sara', 'Coutinho', 'sara.coutinho@example.com', 'SaraC@2024', 'Estudante focada em cibersegurança e proteção de dados.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('tiago.j', 'Tiago', 'Jorge', 'tiago.jorge@example.com', 'Ti@goJ!2023', 'Focado em tecnologias emergentes e inovação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('ursula.m', 'Ursula', 'Medeiros', 'ursula.medeiros@example.com', 'Ursul@2023', 'Entusiasta de desenvolvimento de software e UX.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('victor.h', 'Victor', 'Henrique', 'victor.henrique@example.com', 'Victor$H2023', 'Interesse em soluções tecnológicas para o meio ambiente.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('wally.b', 'Wally', 'Bento', 'wally.bento@example.com', 'W@llyB4$', 'Estudante de L.EIC com foco em programação e design.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('xuxa.p', 'Xuxa', 'Pereira', 'xuxa.pereira@example.com', 'XuxaP@2024', 'Interessa-se por arte digital e programação criativa.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('yumi.t', 'Yumi', 'Tanaka', 'yumi.tanaka@example.com', 'YumiT@2023', 'Focada em desenvolvimento de jogos e IA.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('zara.m', 'Zara', 'Mendes', 'zara.mendes@example.com', 'Zara$1234', 'Entusiasta em ciência da computação e algoritmos.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('andre.s', 'André', 'Silva', 'andre.silva@example.com', 'Andr3$2023', 'Interesse em novas tecnologias e inovação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('belinda.d', 'Belinda', 'Dias', 'belinda.dias@example.com', 'B3linda@2024', 'Estudante com interesse em redes sociais e marketing digital.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('cynthia.r', 'Cynthia', 'Ribeiro', 'cynthia.ribeiro@example.com', 'Cynthi@R2023', 'Interessa-se por desenvolvimento de aplicativos móveis.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('dani.g', 'Daniel', 'Gama', 'dani.gama@example.com', 'DaniG@2024', 'Entusiasta de UX/UI e design de interação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('eloisa.b', 'Eloisa', 'Barros', 'eloisa.barros@example.com', 'Eloisa$1234', 'Estudante de L.EIC apaixonada por inovação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('fiona.d', 'Fiona', 'Duarte', 'fiona.duarte@example.com', '$2y$10$dBFeAuWUibrrLrNxntMZreqA0z46cMpFMNeMH9EnQ5oDxG0ZTgPxa', 'Interesse em big data e análise de dados.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('gilda.m', 'Gilda', 'Melo', 'gilda.melo@example.com','$2y$10$dBFeAuWUibrrLrNxntMZreqA0z46cMpFMNeMH9EnQ5oDxG0ZTgPxa', 'Focada em tecnologias emergentes e engenharia de software.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('hilary.p', 'Hilary', 'Pinto', 'hilary.pinto@example.com', 'H!laryP@2024', 'Entusiasta do desenvolvimento de jogos e animação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('ivan.n', 'Ivan', 'Nunes', 'ivan.nunes@example.com', 'IvanN@2024', 'Estudante de L.EIC com foco em IA.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('joaquim.r', 'Joaquim', 'Reis', 'joaquim.reis@example.com', 'Jo@quimR2024', 'Interesse em engenharia de software e IoT.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('kelly.c', 'Kelly', 'Castro', 'kelly.castro@example.com', 'K3llyC@2024', 'Focada em desenvolvimento sustentável e tecnologia.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('lucas.s', 'Lucas', 'Santos', 'lucas.santos@example.com', 'LucaS@2024', 'Estudante de L.EIC apaixonado por inovação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('madalena.b', 'Madalena', 'Braga', 'madalena.braga@example.com', 'Madal3na!2023', 'Interesse em UI/UX e design digital.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('nathalia.r', 'Nathalia', 'Ramos', 'nathalia.ramos@example.com', 'N@thalia2023', 'Focada em cibersegurança e privacidade.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('oliver.l', 'Oliver', 'Lopes', 'oliver.lopes@example.com', 'Oliv3r@2024', 'Estudante de L.EIC com interesse em robótica.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('pablo.t', 'Pablo', 'Teixeira', 'pablo.teixeira@example.com', 'Pab!oT2023', 'Interesse em novas tecnologias e inovação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('quiteria.c', 'Quitéria', 'Castro', 'quiteria.castro@example.com', 'Quit3riaC!', 'Entusiasta de desenvolvimento web e mobile.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('rafaela.p', 'Rafaela', 'Pereira', 'rafaela.pereira@example.com', 'RafaelaP@2024', 'Focada em análise de dados e inteligência artificial.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('santiago.m', 'Santiago', 'Moraes', 'santiago.moraes@example.com', 'Santi@2023', 'Estudante de L.EIC com paixão por engenharia de software.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('tania.s', 'Tânia', 'Santos', 'tania.santos@example.com', 'T@nia2023', 'Interesse em big data e análise de sistemas.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('ursula.b', 'Ursula', 'Barreto', 'ursula.barreto@example.com', 'Ursul@B2023', 'Focada em desenvolvimento web e UX.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('vincent.a', 'Vincent', 'Alves', 'vincent.alves@example.com', 'V!ncentA@2023', 'Entusiasta de ciência da computação e IA.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('wendy.g', 'Wendy', 'Gomes', 'wendy.gomes@example.com', 'Wendy!G2024', 'Estudante de L.EIC com interesse em inovação.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('xander.j', 'Xander', 'Jardim', 'xander.jardim@example.com', 'XanderJ@2023', 'Focado em tecnologias emergentes e design de produtos.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('yara.t', 'Yara', 'Teixeira', 'yara.teixeira@example.com', 'Yara!T@2024', 'Entusiasta de programação e design gráfico.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'),
('zelda.m', 'Zelda', 'Mendonça', 'zelda.mendonca@example.com', 'ZeldaM!2023', 'Interesse em desenvolvimento de software e design.','profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg');


INSERT INTO askLeic.admin(admin_id)
VALUES
(1),
(2),
(3),
(4),
(5);

INSERT INTO askLeic.moderator (moderator_id)
VALUES
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15);


INSERT INTO askLeic.verified_user (user_id, degree, school,status)
VALUES
(1, 'Licenciatura em Engenharia Informática', 'Universidade do Porto',TRUE),
(2, 'Mestrado em Ciência da Computação', 'Universidade de Lisboa', TRUE),
(3, 'Licenciatura em Sistemas de Informação', 'Universidade do Porto', TRUE);



INSERT INTO askLeic.question (title, content, created_date, edited_date, author_id)
VALUES
    ('Avaliação de Sistemas Operativos', 'Como funciona a avaliação na cadeira de Sistemas Operativos? Alguém pode partilhar as datas dos testes?', '2024-04-01 10:30:00', NULL, 1),
    ('Datas de Entregas em Programação', 'Quando são as entregas dos projetos em Programação? Alguém sabe as datas?', '2024-03-10 14:00:00', NULL, 2),
    ('Horários de Aulas', 'Pessoal, alguém tem o horário das aulas de Estruturas de Dados? Não consigo encontrar!', '2024-04-15 11:15:00', NULL, 8),
    ('Espaço de Estudo na FEUP', 'Onde é que costumam estudar na FEUP? Algum espaço tranquilo que recomendem?', '2024-03-20 16:45:00', NULL, 9),
    ('Funcionamento da Biblioteca', 'A biblioteca da FEUP tem algum horário específico?', '2024-02-25 13:20:00', NULL, 10),
    ('Bares e Cafés da FEUP', 'Quais são os melhores bares ou cafés na FEUP? Algum que tenham experimentado recentemente?', '2024-04-22 09:50:00', NULL, 11),
    ('Dúvidas sobre Avaliação', 'Alguém tem dúvidas sobre como funcionam os critérios de avaliação em Desenvolvimento Web?', '2024-03-28 15:00:00', NULL, 12),
    ('Seminários e Workshops', 'Quando são os seminários e workshops que temos de participar? Alguma informação sobre isso?', '2024-01-15 10:10:00', NULL, 13),
    ('Uso do Moodle', 'Como funcionam os recursos do Moodle para as cadeiras? Alguém pode explicar como aceder?', '2024-02-10 14:30:00', NULL, 14),
    ('Testes de Redes de Computadores', 'Alguém já fez o teste de Redes de Computadores? Como é a dinâmica? O que estudar?', '2024-05-05 11:45:00', NULL, 15),
    ('Mentorias com Professores', 'Como funcionam as mentorias com os professores? Alguém já participou?', '2024-03-12 13:30:00', NULL, 16),
    ('Atividades Extra-Curriculares', 'Que atividades extra-curriculares têm? Alguma que valha a pena?', '2024-04-05 17:00:00', NULL, 17),
    ('Materiais de Estudo', 'Alguém tem recomendações de livros ou sites úteis para a cadeira de Análise de Algoritmos?', '2024-05-01 12:30:00', NULL, 18),
    ('Eventos na FEUP', 'Sabem de eventos interessantes que vão acontecer na FEUP? Algum que devemos participar?', '2024-03-22 15:50:00', NULL, 19),
    ('Faltas e Justificações', 'Como devemos proceder se tivermos faltas? O que é necessário para justificar?', '2024-02-14 11:00:00', NULL, 20),
    ('Utilização de Laboratórios', 'Como é que funciona a utilização dos laboratórios de informática? Tem que reservar?', '2024-01-30 10:15:00', NULL, 21),
    ('Convivência entre Alunos', 'Alguém tem dicas sobre como fazer novas amizades na FEUP? Estou um pouco perdido!', '2024-04-09 14:20:00', NULL, 23),
    ('Ambiente da FEUP', 'Como é o ambiente geral na FEUP? O que devemos esperar como caloiros?', '2024-05-10 12:00:00', NULL, 24),
    ('Entregas em Gestão de Projetos', 'Quando é que são as entregas para a cadeira de Gestão de Projetos? E como são avaliadas?', '2024-03-18 13:50:00', NULL, 25),
    ('Cursos de Verão', 'Algum de vocês vai participar nos cursos de verão? Quais são os mais recomendados?', '2024-04-25 16:30:00', NULL, 26),
    ('Suporte Técnico na FEUP', 'Como posso aceder ao suporte técnico da FEUP para problemas com o Wi-Fi?', '2024-05-15 10:00:00', NULL, 27),
    ('Atividades de Integração', 'Quando acontecem as atividades de integração para os caloiros? Como funcionam?', '2024-01-20 14:45:00', NULL, 28),
    ('Bolsa de Estudo', 'Alguém sabe como funciona o processo de candidatura à bolsa de estudo? É complicado?', '2024-02-02 11:30:00', NULL, 29),
    ('Estágios e Oportunidades', 'Quando começam as candidaturas para estágios? Alguma dica sobre como se preparar?', '2024-06-03 09:00:00', NULL, 30),
    ('Horários de Exames', 'Quais são as datas dos exames finais para este semestre?', '2024-06-10 10:00:00', NULL, 1),
    ('Troca de Notas', 'Alguém sabe como funciona o processo de revisão de notas? Posso pedir uma revisão?', '2024-05-20 15:30:00', NULL, 2),
    ('Vagas para Aulas Práticas', 'Existem vagas para as aulas práticas de Algoritmos? Onde posso me inscrever?', '2024-04-10 13:00:00', NULL, 3),
    ('Descontos para Estudantes', 'Alguém sabe como obter descontos em transportes públicos sendo estudante da FEUP?', '2024-03-30 09:15:00', NULL, 4),
    ('Rastreio de Projetos em Desenvolvimento Web', 'Como posso verificar o progresso do meu projeto de Desenvolvimento Web? Existe algum sistema de rastreamento?', '2024-03-15 11:10:00', NULL, 5),
    ('Inscrição em Cadeiras Opcionais', 'Quando começa o período de inscrição para as cadeiras opcionais do próximo semestre?', '2024-04-28 10:30:00', NULL, 6),
    ('Feiras de Emprego', 'Quando é a próxima feira de emprego na FEUP? Alguém sabe quais empresas estarão presentes?', '2024-05-02 14:00:00', NULL, 7),
    ('Programas de Intercâmbio', 'Alguém já fez o programa de intercâmbio? Como funciona o processo de candidatura?', '2024-04-18 12:40:00', NULL, 8),
    ('Refeições no Restaurante Académico', 'Qual é o melhor horário para evitar filas no restaurante académico?', '2024-03-05 13:00:00', NULL, 9),
    ('Equipamentos de Desporto na FEUP', 'Onde posso alugar equipamentos para as atividades desportivas na FEUP?', '2024-02-20 14:15:00', NULL, 10),
    ('Bolsas de Estudo para Pós-Graduação', 'Alguém sabe como posso candidatar-me às bolsas de estudo para pós-graduação?', '2024-06-01 09:45:00', NULL, 11),
    ('Dúvidas sobre o Processo de Matrícula', 'Alguém tem dificuldades com o processo de matrícula para o próximo semestre?', '2024-04-12 16:00:00', NULL, 12),
    ('Estudos em Grupo', 'Alguém já formou grupos de estudo para a cadeira de Redes de Computadores? Estou à procura de grupo!', '2024-04-14 18:30:00', NULL, 13),
    ('Calendário de Eventos Académicos', 'Onde posso encontrar o calendário completo de eventos acadêmicos da FEUP?', '2024-02-28 15:00:00', NULL, 14),
    ('Opções de Alojamento para Estudantes', 'Alguém tem dicas de alojamento para estudantes fora do campus?', '2024-05-10 17:00:00', NULL, 15),
    ('Refeições Saudáveis na FEUP', 'Alguém sabe onde posso encontrar opções de refeição mais saudáveis na FEUP?', '2024-03-13 12:20:00', NULL, 16),
    ('Atividades Culturais na FEUP', 'Que atividades culturais acontecem na FEUP? Alguém sabe se há eventos culturais interessantes no próximo mês?', '2024-04-08 11:00:00', NULL, 17),
    ('Utilização de Impressoras na FEUP', 'Onde posso encontrar impressoras na FEUP? Existe algum procedimento específico?', '2024-05-20 13:30:00', NULL, 18),
    ('Passeios de Integração', 'Quais são os passeios de integração organizados pela FEUP para os novos alunos?', '2024-03-17 10:30:00', NULL, 19),
    ('Laboratórios de Física', 'Onde ficam os laboratórios de Física? Precisamos de algum material específico?', '2024-04-03 14:45:00', NULL, 20),
    ('Trabalho Final de Mestrado', 'Alguém tem dicas sobre como iniciar o trabalho final de mestrado na FEUP?', '2024-05-25 11:50:00', NULL, 21),
    ('Concursos de Programação', 'Alguém sabe de concursos de programação que possam ser interessantes para os alunos da FEUP?', '2024-04-01 17:40:00', NULL, 22),
    ('Oportunidades de Voluntariado', 'Quais são as oportunidades de voluntariado na FEUP? Alguma experiência para partilhar?', '2024-03-26 13:30:00', NULL, 23),
    ('Conselhos para Iniciar na Engenharia', 'Alguém tem conselhos sobre como iniciar no curso de Engenharia na FEUP? Dicas para caloiros?', '2024-04-19 16:10:00', NULL, 24),
    ('Aulas Online vs Presenciais', 'Quais são as vantagens e desvantagens das aulas online e presenciais na FEUP?', '2024-02-18 14:30:00', NULL, 25),
    ('Estágio em Empresas de Tecnologia', 'Quais são as melhores empresas para fazer estágio em Tecnologia? Alguém tem recomendações?', '2024-06-07 10:20:00', NULL, 26),
    ('Apoio a Empreendedores na FEUP', 'A FEUP oferece apoio a estudantes que querem começar um projeto empreendedor? Quais são as opções?', '2024-04-30 15:00:00', NULL, 27),
    ('Planejamento de Estudo para Exames', 'Alguém tem um bom planejamento de estudo para a época de exames que possa partilhar?', '2024-05-12 12:00:00', NULL, 28),
    ('Ajuda com Programação em Python', 'Estou com dificuldades em Python. Alguém pode me ajudar a entender melhor?', '2024-04-07 14:50:00', NULL, 29),
    ('Feiras de Ciências e Tecnologia', 'Alguém vai participar nas feiras de ciências e tecnologia? Onde posso me inscrever?', '2024-06-12 11:00:00', NULL, 30);


INSERT INTO askLeic.tag(acronym, full_name, description)
VALUES
    ('AED', 'Algoritmos e Estruturas de Dados', ' '),
    ('BD', 'Bases de Dados', ' '),
    ('AC', 'Arquitetura de Computadores', ' '),
    ('ESOF', 'Engenharia de Software', ' '),
    ('IPC', 'Interação Pessoa Computador', ' '),
    ('IA', 'Inteligência Artificial', ' '),
    ('ALGA', 'Álgebra Linear e Geometria Analítica', ' '),
    ('LCOM', 'Laboratórios de Computadores', ' '),
    ('P', 'Programação', ' '),
    ('RE', 'Redes de Computadores', ' '),
    ('SO', 'Sistemas Operativos', ' '),
    ('TC', 'Teoria da Computação', ' '),
    ('PI', 'Projeto Integrador', ' '),
    ('FSI', 'Fundamentos de Segurança Informática', ' '),
    ('C', 'Compiladores', ' '),
    ('CPD', 'Computação Paralela e Distribuída', ' '),
    ('AMI', 'Análise Matemática I', ' '),
    ('AMII', 'Análise Matemática II', ' '),
    ('MD', 'Matemática Discreta', ' '),
    ('LTW', 'Linguagens e Tecnologias Web', ' '),
    ('LBAW', 'Laboratório de Bases de Dados e Aplicações Web', ' '),
    ('DA', 'Desenho de Algoritmos', ' '),
    ('ME', 'Métodos Estatísticos', ' '),
    ('LDTS', 'Laboratório de Desenho e Teste de Software', ' '),
    ('F I', 'Física I', ' '),
    ('F II', 'Física II', ' '),
    ('PUP', 'Projeto UP', ' '),
    ('PFL', 'Programação Funcional e Lógica', ' '),
    ('CG', 'Computação Gráfica', ' '),
    ('FP', 'Fundamentos da Programação', ' '),
    ('FSC', 'Fundamentos de Sistemas Computacionais', ' '),

    -- Tags sociais
    ('Eventos', 'Eventos e Atividades', ' '),
    ('Grupos', 'Grupos de Estudo', ' '),
    ('Sociais', 'Interações Sociais', ' '),
    ('Mentoria', 'Mentoria e Apoio Académico', ' '),
    ('Estágios', 'Oportunidades de Estágio', ' '),
    ('Voluntariado', 'Atividades de Voluntariado', ' ');


INSERT INTO askLeic.badge (name, description)
VALUES
('Iniciante', 'Publicaste a tua primeira pergunta!'),
('Explorador', 'Publicaste 5 perguntas no fórum!'),
('Contribuinte', 'Publicaste 10 perguntas e ajudaste a comunidade!'),
('Interagidor', 'Recebeste 10 upvotes nas tuas perguntas!'),
('Respondo sempre', 'Respondeste a 5 perguntas de outros utilizadores!'),
('Ajuda da comunidade', 'Recebeste 5 upvotes nas tuas respostas!'),
('Guru', 'Publicaste 20 perguntas e respondeste a 10!'),
('Colaborador ativo', 'Participaste em 50 interações no fórum!'),
('Mentor', 'Ajudaste outros utilizadores com 10 respostas úteis!'),
('Super Utilizador', 'Recebeste 100 upvotes no total nas tuas perguntas e respostas!');


INSERT INTO askLeic.answer (content, created_date, edited_date, verified)
VALUES
('A avaliação consiste em um exame final e dois minitestes. As datas são anunciadas no início do semestre.', '2024-09-12 14:00:00', NULL, TRUE),
('Sim, já fiz! Normalmente saem perguntas teóricas e exercícios práticos sobre os modelos OSI/TCP-IP, endereçamento IP e subnetting. Foca nos exemplos das aulas e exercícios de redes. Boa sorte!', '2024-10-05 09:30:00', NULL, FALSE),
('Os projetos têm de ser entregues na última semana do semestre. Não se esqueçam de verificar as datas específicas na plataforma Moodle!', '2024-10-10 11:15:00', NULL, TRUE),
('O espaço da FEUP é bastante agradável, especialmente a nova área de estudo. Vale a pena conhecer!', '2024-09-20 16:45:00', NULL, FALSE),
('A biblioteca está aberta até às 22h durante a semana e até às 18h aos fins de semana.', '2024-09-18 12:00:00', NULL, TRUE),
('O novo espaço de coworking da FEUP é ótimo para fazer trabalho de grupo. Tem muitas tomadas e boa internet!', '2024-09-28 13:40:00', NULL, TRUE),
('This is a reply to the first answer.','2024-09-28 13:40:00', NULL, TRUE),
('Replying to the second answer.','2024-09-28 13:40:00', NULL, FALSE),
('Another reply to the first answer.','2024-09-28 13:40:00', NULL, TRUE);


INSERT INTO askLeic.report (motive, report_type, date, reporter_id)
VALUES
('Postagem considerada ofensiva.', 'answer_report', '2024-01-15 10:30:00', 1),
('Pergunta não relevante ao tópico.', 'question_report', '2024-01-18 13:15:00', 4);


INSERT INTO askLeic.vote (vote_type, user_id) VALUES
(TRUE, 1),   -- Example: User with ID 1 liked a post
(FALSE, 2),  -- Example: User with ID 2 disliked a post
(TRUE, 3),   -- Example: User with ID 3 liked a post
(FALSE, 1),  -- Example: User with ID 1 disliked a different post
(TRUE, 4);   -- Example: User with ID 4 liked a post


INSERT INTO askLeic.notification (user_id, question_id, responder_id, created_at, is_read)
VALUES 
(10, 1, 2, CURRENT_TIMESTAMP - INTERVAL '1 day', FALSE),
(15, 2, 3, CURRENT_TIMESTAMP - INTERVAL '2 days', FALSE),
(20, 3, 4, CURRENT_TIMESTAMP - INTERVAL '3 days', FALSE),
(25, 4, 5, CURRENT_TIMESTAMP - INTERVAL '4 days', FALSE),
(30, 5, 6, CURRENT_TIMESTAMP - INTERVAL '5 days', FALSE);



-- LINK RELATIONS

INSERT INTO askLeic.badge_notification (notification_id, badge_id)
VALUES 
(1, 1),
(2, 2);

INSERT INTO askLeic.question_notification (notification_id, question_id, vote_id)
VALUES 
(1, 1, 1),
(2, 1, 2),
(3, 2, NULL),
(4, 2, 1),
(5, 3, 2);

INSERT INTO askLeic.answer_notification (notification_id, answer_id, vote_id)
VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, NULL),  
(4, 2, 1),
(5, 3, 2);


INSERT INTO askLeic.awarded_badges (user_id, badge_id)
VALUES
(1, 1), (2, 2), (3, 3), (4, 4), (5, 5);


INSERT INTO askLeic.answer_to_question (answer_id, question_id)
VALUES 
(3, 2),
(1, 1),
(5, 5),
(2, 10),
(4, 4);

INSERT INTO askLeic.answer_to_answer (answer_reply, answer)
VALUES 
(6, 4),
(7, 2), -- "This is a reply to the first answer."
(8, 2), -- "Replying to the second answer."
(9, 2);

INSERT INTO askLeic.user_verifies_answer (answer_id, user_id)
VALUES 
(1, 1), (2, 2), (3, 3);


INSERT INTO askLeic.user_posts_answer (answer_id, user_id)
VALUES 
(1, 1), (2, 2), (3, 3);


--INSERT INTO askLeic.question_reports (report_id, question_id)
--VALUES 
--(1, 3);  -- Report ID 1 also linked to Question ID 3

--INSERT INTO askLeic.answer_reports (report_id, answer_id)
--VALUES 
--(2, 3);  -- Report ID 2 linked to Answer ID 2

INSERT INTO askLeic.question_has_tag (question_id, tag_id)
VALUES 
(1, 1), (2, 2), (3, 3);


INSERT INTO askLeic.vote_on_question (vote_id, question_id)
VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

INSERT INTO askLeic.vote_on_answer (vote_id, answer_id)
VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

INSERT INTO askLeic.user_has_notification (notification_id, user_id)
VALUES 
(1, 10),
(2, 15),
(3, 20),
(4, 25),
(5, 30);