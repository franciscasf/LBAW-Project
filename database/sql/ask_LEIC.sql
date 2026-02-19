DROP SCHEMA IF EXISTS askLeic CASCADE;
CREATE SCHEMA askLeic;

SET search_path TO askLeic;

----------------------
-- DROP TABLES
----------------------
DROP TABLE IF EXISTS askLeic."user"; -- R01
DROP TABLE IF EXISTS askLeic.admin; -- R02
DROP TABLE IF EXISTS askLeic.moderator; -- R03
DROP TABLE IF EXISTS askLeic.authenticated_user; -- R04
DROP TABLE IF EXISTS askLeic.verified_user; -- R05
DROP TABLE IF EXISTS askLeic.question; -- R06
DROP TABLE IF EXISTS askLeic.tag; -- R07
DROP TABLE IF EXISTS askLeic.badge; -- R08
DROP TABLE IF EXISTS askLeic.report; -- R09
DROP TABLE IF EXISTS askLeic.answer; -- R10
DROP TABLE IF EXISTS askLeic.vote; -- R11
DROP TABLE IF EXISTS askLeic.notification; -- R12
DROP TABLE IF EXISTS askLeic.badge_notification; -- R13
DROP TABLE IF EXISTS askLeic.question_notification; -- R14
DROP TABLE IF EXISTS askLeic.answer_notification; -- R15
DROP TABLE IF EXISTS askLeic.awarded_badges; -- R16
DROP TABLE IF EXISTS askLeic.answer_to_question; -- R17 
DROP TABLE IF EXISTS askLeic.answer_to_answer; -- R18
DROP TABLE IF EXISTS askLeic.user_verifies_answer; -- R19 
DROP TABLE IF EXISTS askLeic.user_posts_answer; -- R20
DROP TABLE IF EXISTS askLeic.question_reports; -- R21
DROP TABLE IF EXISTS askLeic.answer_reports; -- R22
DROP TABLE IF EXISTS askLeic.question_has_tag; -- R23
DROP TABLE IF EXISTS askLeic.vote_on_question; -- R24
DROP TABLE IF EXISTS askLeic.vote_on_answer; -- R25
DROP TABLE IF EXISTS askLeic.user_has_notification; -- R26
DROP TABLE IF EXISTS askLeic.user_follows_question; 
DROP TABLE IF EXISTS askLeic.user_follows_tag; 
DROP TABLE IF EXISTS askLeic.blocked_user;



----------------------
-- Drop Types
----------------------
DROP TYPE IF EXISTS question_notification_types;
DROP TYPE IF EXISTS answer_notification_types;
DROP TYPE IF EXISTS vote_types ;
DROP TYPE IF EXISTS report_types;


----------------------
-- Types
----------------------
-- Tipo ENUM para tipos de notificação de perguntas
CREATE TYPE question_notification_types AS ENUM ('Voted_up', 'Voted_down', 'Reply');

-- Tipo ENUM para tipos de notificação de respostas
CREATE TYPE answer_notification_types AS ENUM ('Voted_up', 'Voted_down', 'Reply', 'Verified');

-- Tipo ENUM para tipos de votos
CREATE TYPE vote_types AS ENUM ('upvote', 'downvote');

-- Tipo ENUM para tipos de reports
CREATE TYPE report_types AS ENUM ('answer_report', 'question_report');


----------------------
-- TABLE CREATION
----------------------
CREATE TABLE "user" ( -- R01 -- as aspas significa que e case sensitive
    user_id SERIAL PRIMARY KEY NOT NULL,
    name TEXT UNIQUE NOT NULL CHECK (LENGTH(name) BETWEEN 3 AND 20),
    first_name TEXT  CHECK (LENGTH(first_name) <= 20),
    last_name TEXT  CHECK (LENGTH(last_name) <= 20),
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL CHECK (LENGTH(password) >= 6),
    description TEXT CHECK (LENGTH(description) <= 150),
    remember_token VARCHAR(100) DEFAULT NULL,
    profile_picture TEXT
);

CREATE TABLE admin ( -- R02
    admin_id INTEGER PRIMARY KEY NOT NULL,
    FOREIGN KEY (admin_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE
);


CREATE TABLE moderator ( -- R03
    moderator_id INTEGER PRIMARY KEY NOT NULL,
    FOREIGN KEY (moderator_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE
);

CREATE TABLE blocked_user ( 
    blockedUser_id INTEGER PRIMARY KEY NOT NULL,
    FOREIGN KEY (blockedUser_id) REFERENCES askLeic."user"(user_id) 
);

CREATE TABLE verified_user ( -- R05
    user_id INTEGER PRIMARY KEY NOT NULL,
    degree TEXT NOT NULL,
    school TEXT NOT NULL,
    status BOOLEAN NOT NULL DEFAULT FALSE,
    id_picture TEXT,
    FOREIGN KEY (user_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE
);

CREATE TABLE question ( -- R06
    question_id SERIAL PRIMARY KEY NOT NULL,
    title TEXT NOT NULL CHECK(LENGTH(title) <= 150),
    content TEXT NOT NULL CHECK(LENGTH(content) <= 1500),
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    edited_date TIMESTAMP CHECK (edited_date IS NULL OR created_date < edited_date),
    author_id INTEGER NOT NULL,
    FOREIGN KEY (author_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE
);

CREATE TABLE tag ( --R07
    tag_id SERIAL PRIMARY KEY NOT NULL,
    acronym TEXT UNIQUE NOT NULL,
    full_name TEXT UNIQUE NOT NULL,
    description TEXT NOT NULL CHECK (LENGTH(description) <= 300)
);

CREATE TABLE badge ( --R08
    badge_id SERIAL PRIMARY KEY NOT NULL,
    name TEXT UNIQUE NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE report ( -- R09
    report_id SERIAL PRIMARY KEY NOT NULL,
    motive TEXT NOT NULL CHECK(LENGTH(motive) <= 1500),
    report_type report_types NOT NULL, -- confirmar
    date TIMESTAMP NOT NULL,
    reporter_id INTEGER NOT NULL,
    FOREIGN KEY (reporter_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE
);

CREATE TABLE answer ( --R10
    answer_id SERIAL PRIMARY KEY NOT NULL,
    content TEXT NOT NULL CHECK(LENGTH(content) <= 1500),
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    edited_date TIMESTAMP CHECK (edited_date IS NULL OR edited_date > created_date),
    verified BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE vote ( -- R11
    vote_id SERIAL PRIMARY KEY NOT NULL,
    vote_type BOOLEAN NOT NULL,
    user_id INTEGER NOT NULL,
    FOREIGN KEY (user_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE
);



CREATE TABLE notification ( -- R12
    notification_id SERIAL PRIMARY KEY,         
    user_id INT NOT NULL,                       
    question_id INT,                            
    answer_id INT,                              
    responder_id INT NOT NULL,                  
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,      
    is_read BOOLEAN DEFAULT FALSE,
    message TEXT CHECK(LENGTH(message) <= 100),        

    -- Restrições e relações
    FOREIGN KEY (user_id) REFERENCES askLeic."user"(user_id),      
    FOREIGN KEY (question_id) REFERENCES askLeic.question(question_id), 
    FOREIGN KEY (answer_id) REFERENCES askLeic.answer(answer_id),     
    FOREIGN KEY (responder_id) REFERENCES askLeic."user"(user_id)   
);



CREATE TABLE badge_notification ( -- R13
    notification_id INTEGER NOT NULL,
    badge_id INTEGER NOT NULL,
    PRIMARY KEY (notification_id, badge_id),
    FOREIGN KEY (notification_id) REFERENCES askLeic.notification(notification_id) ON DELETE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES askLeic.badge(badge_id) ON DELETE CASCADE
);

CREATE TABLE question_notification ( -- R14
    notification_id INTEGER NOT NULL,
    question_id INTEGER NOT NULL,
    vote_id INTEGER,
    PRIMARY KEY (notification_id, question_id),
    FOREIGN KEY (notification_id) REFERENCES askLeic.notification(notification_id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES askLeic.question(question_id) ON DELETE CASCADE,
    FOREIGN KEY (vote_id) REFERENCES askLeic.vote(vote_id) ON DELETE CASCADE
);

CREATE TABLE answer_notification ( -- R15
    notification_id INTEGER NOT NULL,
    answer_id INTEGER NOT NULL,
    vote_id INTEGER,
    PRIMARY KEY (notification_id, answer_id),
    FOREIGN KEY (notification_id) REFERENCES askLeic.notification(notification_id) ON DELETE CASCADE,
    FOREIGN KEY (answer_id) REFERENCES askLeic.answer(answer_id) ON DELETE CASCADE,
    FOREIGN KEY (vote_id) REFERENCES askLeic.vote(vote_id) ON DELETE CASCADE
);

CREATE TABLE awarded_badges ( -- R16
    user_id INTEGER NOT NULL,
    badge_id INTEGER NOT NULL,
    PRIMARY KEY (user_id, badge_id),
    FOREIGN KEY (user_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES askLeic.badge(badge_id) ON DELETE CASCADE
);

CREATE TABLE answer_to_question ( -- R17
    answer_id INTEGER NOT NULL,
    question_id INTEGER NOT NULL,
    PRIMARY KEY (answer_id, question_id),
    FOREIGN KEY (answer_id) REFERENCES askLeic.answer(answer_id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES askLeic.question(question_id) ON DELETE CASCADE
);

CREATE TABLE answer_to_answer ( -- R18
    answer_reply INTEGER NOT NULL,
    answer INTEGER NOT NULL,
    PRIMARY KEY (answer_reply, answer),
    FOREIGN KEY (answer_reply) REFERENCES askLeic.answer(answer_id) ON DELETE CASCADE,
    FOREIGN KEY (answer) REFERENCES askLeic.answer(answer_id) ON DELETE CASCADE
);

CREATE TABLE user_verifies_answer ( -- R19
    answer_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    PRIMARY KEY (answer_id, user_id),
    FOREIGN KEY (answer_id) REFERENCES askLeic.answer(answer_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE
);

CREATE TABLE user_posts_answer ( -- R20
    answer_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    PRIMARY KEY (answer_id, user_id),
    FOREIGN KEY (answer_id) REFERENCES askLeic.answer(answer_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE
);

CREATE TABLE question_reports ( -- R21
    report_id INTEGER NOT NULL,
    question_id INTEGER NOT NULL,
    PRIMARY KEY (report_id, question_id),
    FOREIGN KEY (report_id) REFERENCES askLeic.report(report_id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES askLeic.question(question_id) ON DELETE CASCADE
);

CREATE TABLE answer_reports ( -- R22
    report_id INTEGER NOT NULL,
    answer_id INTEGER NOT NULL,
    PRIMARY KEY (report_id, answer_id),
    FOREIGN KEY (report_id) REFERENCES askLeic.report(report_id) ON DELETE CASCADE,
    FOREIGN KEY (answer_id) REFERENCES askLeic.answer(answer_id) ON DELETE CASCADE
);

CREATE TABLE question_has_tag ( -- R23
    question_id INTEGER NOT NULL,
    tag_id INTEGER NOT NULL,
    PRIMARY KEY (question_id, tag_id),
    FOREIGN KEY (question_id) REFERENCES askLeic.question(question_id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES askLeic.tag(tag_id) ON DELETE CASCADE
);

CREATE TABLE vote_on_question ( -- R24
    vote_id INTEGER NOT NULL,
    question_id INTEGER NOT NULL,
    PRIMARY KEY (vote_id, question_id),
    FOREIGN KEY (vote_id) REFERENCES askLeic.vote(vote_id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES askLeic.question(question_id) ON DELETE CASCADE
);

CREATE TABLE vote_on_answer ( -- R25
    vote_id INTEGER NOT NULL,
    answer_id INTEGER NOT NULL,
    PRIMARY KEY (vote_id, answer_id),
    FOREIGN KEY (vote_id) REFERENCES askLeic.vote(vote_id) ON DELETE CASCADE,
    FOREIGN KEY (answer_id) REFERENCES askLeic.answer(answer_id) ON DELETE CASCADE
);

CREATE TABLE user_has_notification ( -- R26
    notification_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    PRIMARY KEY (notification_id, user_id),
    FOREIGN KEY (notification_id) REFERENCES askLeic.notification(notification_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE
);


CREATE TABLE user_follows_tag (
    user_id INTEGER NOT NULL,
    tag_id INTEGER NOT NULL,
    PRIMARY KEY (user_id, tag_id),
    FOREIGN KEY (user_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES askLeic.tag(tag_id) ON DELETE CASCADE
);

CREATE TABLE user_follows_question (
    user_id INTEGER NOT NULL,
    question_id INTEGER NOT NULL,
    follow_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, question_id),
    FOREIGN KEY (user_id) REFERENCES askLeic."user"(user_id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES askLeic.question(question_id) ON DELETE CASCADE
);



----------------------------------
-- INDICES
----------------------------------

---------------------------
-- PERFORMANCE INDICES


-- Index for filtering questions by tags
CREATE INDEX idx_questiontag_tag_question_filter ON askLeic.question_has_tag USING hash (tag_id); -- later may be change to btree

-------- Indices for date-based access to improve retrieval of newly created or updated content
CREATE INDEX idx_question_creation ON askLeic.question USING btree (created_date);
CREATE INDEX idx_answer_creation ON askLeic.answer USING btree (created_date);

--Index to facilitate vote counting in questions
CREATE INDEX idx_question_vote ON askLeic.vote_on_question USING hash (question_id);-- later may be change to btree

-- Index to facilitate vote counting in answers
CREATE INDEX idx_answer_vote ON askLeic.vote_on_answer USING hash (answer_id);-- later may be change to btree


----- Additional utility index for moderation and administrative functionalities
CREATE INDEX idx_tag_usage ON askLeic.question_has_tag USING btree (tag_id);

----- Indices for accessing user-specific data quickly:
-- get the questions of a certain user
CREATE INDEX idx_user_posts_question ON askLeic.question USING hash (author_id);
--get the answers of a certain user
CREATE INDEX idx_user_posts_answer ON askLeic.user_posts_answer USING hash (user_id);
-- get the notifications of a certain user, not clustered since the notifications table should be updated frequently
CREATE INDEX idx_user_notification_user ON askLeic.user_has_notification USING btree (user_id);


---------------------------
-- FULL TEXT SEARCH INDICES


-- Full-text search capabilities to enhance content discoverability
CREATE INDEX idx_fts_questions ON askLeic.question USING GIN (to_tsvector('portuguese', content));
CREATE INDEX idx_fts_answers ON askLeic.answer USING GIN (to_tsvector('portuguese', content));
CREATE INDEX idx_fts_users ON askLeic."user" USING GIN (to_tsvector('simple', replace(name, '.', ' ')));


-- Enhances the searchability of tags and titles within the questions
-- tag index w/o filter of question search that possess specific tags(looks with the id)

ALTER TABLE askLeic.question ADD COLUMN title_tsvectors TSVECTOR; --add the tsvector column for tags and titles in the question table

CREATE FUNCTION questions_tag_search_update() RETURNS TRIGGER AS $$ --populate ts vector
BEGIN
    NEW.title_tsvectors = to_tsvector('portuguese', NEW.title);
    RETURN NEW;
END $$ LANGUAGE plpgsql;

CREATE TRIGGER questions_tag_search_update
BEFORE INSERT OR UPDATE ON askLeic.question
FOR EACH ROW
EXECUTE PROCEDURE questions_tag_search_update();

CREATE INDEX idx_questions_tsvector ON askLeic.question USING GIN (title_tsvectors);--gin index


-- index para procurar por content das questions
ALTER TABLE askLeic.question ADD COLUMN content_tsvectors TSVECTOR;
CREATE FUNCTION question_title_search_update() RETURNS TRIGGER AS $$
BEGIN
    NEW.content_tsvectors = to_tsvector('portuguese', NEW.content);
    RETURN NEW;
END $$ LANGUAGE plpgsql;


CREATE TRIGGER question_title_search_update
BEFORE INSERT OR UPDATE ON askLeic.question
FOR EACH ROW
EXECUTE PROCEDURE question_title_search_update();
CREATE INDEX idx_question_title_tsvector ON askLeic.question USING GIN (content_tsvectors);



ALTER TABLE askLeic.answer ADD COLUMN answer_tsvectors TSVECTOR;
CREATE FUNCTION answer_search_update() RETURNS TRIGGER AS $$
BEGIN
    NEW.answer_tsvectors = to_tsvector('portuguese', NEW.content);
    RETURN NEW;
END $$ LANGUAGE plpgsql;


CREATE TRIGGER answer_search_update
BEFORE INSERT OR UPDATE ON askLeic.answer
FOR EACH ROW
EXECUTE PROCEDURE answer_search_update();
CREATE INDEX idx_answer_tsvector ON askLeic.answer USING GIN (answer_tsvectors);






------------------------------------------------
-- TRIGGERS
------------------------------------------------

-- Melhora a eficiência da pesquisa de utilizadores pelo nome de utilizador

-- Adiciona a coluna `username_tsvectors` se não existir
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 
        FROM information_schema.columns 
        WHERE table_name='user' AND column_name='username_tsvectors'
    ) THEN
        ALTER TABLE "user" ADD COLUMN username_tsvectors TSVECTOR;
    END IF;
END $$;

-- Cria a função `user_username_search_update`
CREATE OR REPLACE FUNCTION user_username_search_update() RETURNS TRIGGER AS $$
BEGIN
    NEW.username_tsvectors := to_tsvector('portuguese', NEW.name);
    RETURN NEW;
END $$ LANGUAGE plpgsql;

-- Cria o índice `idx_user_username_tsvector`
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 
        FROM pg_class 
        WHERE relname = 'idx_user_username_tsvector'
    ) THEN
        CREATE INDEX idx_user_username_tsvector ON "user" USING GIN (username_tsvectors);
    END IF;
END $$;

-- Cria o trigger `user_username_search_update`
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 
        FROM pg_trigger 
        WHERE tgname = 'user_username_search_update'
    ) THEN
        CREATE TRIGGER user_username_search_update
        BEFORE INSERT OR UPDATE ON askLeic."user"
        FOR EACH ROW
        EXECUTE FUNCTION user_username_search_update();
    END IF;
END $$;



-- Função para ocultar uma pergunta automaticamente quando é reportada várias vezes
/*
CREATE OR REPLACE FUNCTION fn_auto_hide_post() RETURNS TRIGGER AS $$
BEGIN
    -- Define a pergunta como invisível se o número de reports for igual ou maior que 7
    UPDATE askLeic.question
    SET visible = FALSE
    WHERE question_id = NEW.question_id 
    AND (SELECT COUNT(*) FROM askLeic.question_reports WHERE question_id = NEW.question_id) >= 7;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
-- Trigger que chama a função fn_auto_hide_post após a inserção de um report
CREATE TRIGGER AutoHidePost
AFTER INSERT ON askLeic.question_reports
FOR EACH ROW
EXECUTE FUNCTION fn_auto_hide_post();
*/

/*
-- creates a notification when a new answer is added to a question, notifying the question's author
CREATE OR REPLACE FUNCTION fn_notify_new_answer() RETURNS TRIGGER AS $$
DECLARE
    author_id INTEGER;
BEGIN
    SELECT author_id INTO author_id FROM askLeic.question WHERE question_id = NEW.question_id;

    INSERT INTO askLeic.notifications (date)
    VALUES (CURRENT_TIMESTAMP);


    INSERT INTO askLeic.user_has_notification (user_id, notification_id)
    VALUES (author_id, CURRVAL(pg_get_serial_sequence('notification', 'notification_id')));

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_notify_new_answer
AFTER INSERT ON askLeic.answer
FOR EACH ROW
EXECUTE FUNCTION fn_notify_new_answer();
*/

/*
-- Creates a notification when a new vote is added to a question
CREATE OR REPLACE FUNCTION fn_notify_new_vote() RETURNS TRIGGER AS $$
DECLARE
    author_id INTEGER;
BEGIN
    -- Obtém o ID do autor da pergunta
    SELECT author_id INTO author_id FROM askLeic.question WHERE question_id = NEW.question_id;

    -- Insere a notificação
    INSERT INTO notification (date)
    VALUES (CURRENT_TIMESTAMP);

    -- Associa a notificação ao utilizador
    INSERT INTO askLeic.user_has_notification (user_id, notification_id)
    VALUES (author_id, CURRVAL(pg_get_serial_sequence('notification', 'notification_id')));

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_notify_new_vote
AFTER INSERT ON vote_on_question
FOR EACH ROW
EXECUTE FUNCTION fn_notify_new_vote();
*/

-- Creates a notification when a new answer is added as a reply to another answer
CREATE OR REPLACE FUNCTION fn_notify_new_reply() RETURNS TRIGGER AS $$
DECLARE
    original_author_id INTEGER;
BEGIN
    -- Obter o ID do autor da resposta original
    SELECT user_id INTO original_author_id
    FROM askLeic.user_posts_answer
    WHERE answer_id = NEW.answer;

    -- Inserir notificação
    INSERT INTO askLeic.notification (user_id, answer_id, responder_id, created_at)
    VALUES (original_author_id, NEW.answer, NEW.answer_reply, CURRENT_TIMESTAMP);

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

/*
-- Creates a notification when a new vote is added to an answer
CREATE OR REPLACE FUNCTION fn_notify_new_vote_on_answer() RETURNS TRIGGER AS $$
DECLARE
    author_id INTEGER;
BEGIN
    -- Obtém o ID do autor da resposta
    SELECT user_id INTO author_id FROM  askLeic.answer WHERE answer_id = NEW.answer_id;

    -- Insere a notificação
    INSERT INTO notification (date)
    VALUES (CURRENT_TIMESTAMP);

    -- Associa a notificação ao utilizador
    INSERT INTO askLeic.user_has_notification (user_id, notification_id)
    VALUES (author_id, CURRVAL(pg_get_serial_sequence('notification', 'notification_id')));

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_notify_new_vote_on_answer
AFTER INSERT ON  askLeic.vote_on_answer
FOR EACH ROW
EXECUTE FUNCTION fn_notify_new_vote_on_answer();
*/


CREATE OR REPLACE FUNCTION fn_notify_question_reported() RETURNS TRIGGER AS $$
DECLARE
    admin_or_mod INTEGER;
BEGIN
    -- Notificar administradores e moderadores
    FOR admin_or_mod IN (SELECT admin_id FROM askLeic.admin UNION SELECT moderator_id FROM askLeic.moderator) LOOP
        INSERT INTO askLeic.notification (user_id, question_id, responder_id, created_at)
        VALUES (admin_or_mod, NEW.question_id, NEW.reporter_id, CURRENT_TIMESTAMP);
    END LOOP;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER trg_notify_question_reported
AFTER INSERT ON askLeic.question_reports
FOR EACH ROW
EXECUTE FUNCTION fn_notify_question_reported();



CREATE OR REPLACE FUNCTION fn_verify_answer() RETURNS TRIGGER AS $$
BEGIN
    -- If the answer is being marked as verified and is not already verified
    IF NEW.verified = TRUE AND OLD.verified = FALSE THEN
        -- Only perform the update if the answer was not verified previously
        UPDATE askLeic.answer 
        SET verified = TRUE
        WHERE answer_id = NEW.answer_id;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Drop the existing trigger if it exists
DROP TRIGGER IF EXISTS trg_verify_answer ON askLeic.answer;

-- Create the trigger again with the new condition
CREATE TRIGGER trg_verify_answer
AFTER UPDATE ON askLeic.answer
FOR EACH ROW
WHEN (NEW.verified = TRUE AND OLD.verified = FALSE)
EXECUTE FUNCTION fn_verify_answer();


/*
-- Creates a notification when an answer is verified
CREATE OR REPLACE FUNCTION fn_notify_answer_verified() RETURNS TRIGGER AS $$
DECLARE
    author_id INTEGER;
BEGIN
    IF NEW.verified = TRUE AND OLD.verified = FALSE THEN
        SELECT user_id INTO author_id
        FROM askLeic.user_posts_answer
        WHERE answer_id = NEW.answer_id;

        INSERT INTO askLeic.notification (user_id, answer_id, responder_id, date)
        VALUES (author_id, NEW.answer_id, NEW.answer_id, CURRENT_TIMESTAMP);
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER trg_notify_answer_verified
AFTER UPDATE ON  askLeic.answer
FOR EACH ROW
EXECUTE FUNCTION fn_notify_answer_verified();
*/

-- So pode reportar um post uma vez 
CREATE OR REPLACE FUNCTION enforce_one_report_per_user() RETURNS TRIGGER AS $$
DECLARE
    count INT;
BEGIN
    -- Verifica se já existe um report associado ao `reporter_id` para `question_reports`
    IF EXISTS (SELECT 1 FROM askLeic.question_reports WHERE report_id = NEW.report_id) THEN
        SELECT COUNT(*) INTO count
        FROM askLeic.report
        JOIN askLeic.question_reports ON askLeic.report.report_id = askLeic.question_reports.report_id
        WHERE askLeic.report.reporter_id = NEW.reporter_id
        AND askLeic.question_reports.question_id = NEW.question_id;

    -- Caso contrário, verifica para `answer_reports`
    ELSEIF EXISTS (SELECT 1 FROM askLeic.answer_reports WHERE report_id = NEW.report_id) THEN
        SELECT COUNT(*) INTO count
        FROM askLeic.report
        JOIN askLeic.answer_reports ON askLeic.report.report_id = askLeic.answer_reports.report_id
        WHERE askLeic.report.reporter_id = NEW.reporter_id
        AND askLeic.answer_reports.answer_id = NEW.answer_id;
    END IF;

    -- Lança exceção se houver um report correspondente
    IF count > 0 THEN
        RAISE EXCEPTION 'You can only report once per question or answer.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_user_report_before_insert
BEFORE INSERT ON askLeic.report
FOR EACH ROW
EXECUTE FUNCTION enforce_one_report_per_user();



-- Restrição para impedir a edição de respostas verificadas
CREATE OR REPLACE FUNCTION restrict_edit_verified_content() RETURNS TRIGGER AS $$
BEGIN
    -- Prevent editing content for verified answers
    IF OLD.verified = TRUE AND NEW.content IS DISTINCT FROM OLD.content THEN
        RAISE EXCEPTION 'You cannot edit the content of a verified answer.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS check_answer_content_edit ON askLeic.answer;

CREATE TRIGGER check_answer_content_edit
BEFORE UPDATE ON askLeic.answer
FOR EACH ROW
EXECUTE FUNCTION restrict_edit_verified_content();


-- NOVO: para notificações de resposta a perguntas
CREATE OR REPLACE FUNCTION create_question_notification()
RETURNS TRIGGER AS $$
DECLARE
    question_author_id INTEGER;
    related_question_id INTEGER;
    answer_author_id INTEGER;
BEGIN
    -- Obter o ID da pergunta associada à resposta
    SELECT question_id INTO related_question_id
    FROM askLeic.answer_to_question
    WHERE answer_id = NEW.answer_id;

    -- Obter o autor da pergunta
    SELECT author_id INTO question_author_id
    FROM askLeic.question
    WHERE question_id = related_question_id;

    -- Obter o autor da resposta a partir da tabela intermediária user_posts_answer
    SELECT user_id INTO answer_author_id
    FROM askLeic.user_posts_answer
    WHERE answer_id = NEW.answer_id;

    -- Inserir notificação apenas se o autor da pergunta for diferente do autor da resposta
    IF question_author_id IS NOT NULL AND question_author_id != answer_author_id THEN
        INSERT INTO askLeic.notification (user_id, question_id, responder_id, created_at, is_read)
        VALUES (question_author_id, related_question_id, answer_author_id, CURRENT_TIMESTAMP, FALSE);
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Recriar o trigger
DROP TRIGGER IF EXISTS trigger_answer_notification ON askLeic.answer;

CREATE TRIGGER trigger_answer_notification
AFTER INSERT ON askLeic.answer
FOR EACH ROW
EXECUTE FUNCTION create_question_notification();

-------------------------------------
-- TRANSACTIONS
-------------------------------------
-- transaction when an answer is added to a question
CREATE OR REPLACE FUNCTION submit_answer(
    p_content TEXT,                 
    p_question_id INTEGER,          
    p_question_owner_id INTEGER      
) 
RETURNS VOID AS $$
DECLARE
    v_answer_id INT;               
BEGIN
    -- Insert the new answer into the answer table
    INSERT INTO askLeic.answer (content, created_date, verified)
    VALUES (p_content, CURRENT_TIMESTAMP, FALSE) 
    RETURNING answer_id INTO v_answer_id; 

    -- Insert into answer_to_question linking the new answer with the provided question ID
    INSERT INTO askLeic.answer_to_question (answer_id, question_id)
    VALUES (v_answer_id, p_question_id); 

    -- Insert a notification for the question owner
    INSERT INTO askLeic.notification (user_id, created_date, related_id)
    VALUES (p_question_owner_id,  
            CURRENT_TIMESTAMP, 
            v_answer_id); 

    -- No need to explicitly commit, as PL/pgSQL functions are transactional

EXCEPTION
    WHEN OTHERS THEN
        -- Handle the error: log it, rollback, etc.
        RAISE; -- Optionally re-raise the exception for further handling
END;
$$ LANGUAGE plpgsql;


-- transaction that manages the voting process and notifications for both questions and answers
CREATE OR REPLACE FUNCTION submit_vote(
    p_user_id INTEGER,                 
    p_item_id INTEGER,                
    p_vote_type BOOLEAN,              
    p_is_question BOOLEAN               
) 
RETURNS VOID AS $$
DECLARE
    v_vote_id INT;                     
    v_notification_id INT;             
BEGIN
    -- Insert a new vote into the vote table
    INSERT INTO askLeic.vote (vote_type, user_id)
    VALUES (p_vote_type, p_user_id)
    RETURNING vote_id INTO v_vote_id; 

    -- Update the respective vote table
    IF p_is_question THEN
        INSERT INTO askLeic.vote_on_question (vote_id, question_id)
        VALUES (v_vote_id, p_item_id);  

        -- Create a notification for the question vote
        INSERT INTO notification (date)
        VALUES (CURRENT_TIMESTAMP)
        RETURNING notification_id INTO v_notification_id; 

        INSERT INTO askLeic.question_notification (notification_id, question_id, vote_id)
        VALUES (v_notification_id, p_item_id, v_vote_id);  
    ELSE
        INSERT INTO askLeic.vote_on_answer (vote_id, answer_id)
        VALUES (v_vote_id, p_item_id);  

        -- Create a notification for the answer vote
        INSERT INTO askLeic.notification (date)
        VALUES (CURRENT_TIMESTAMP)
        RETURNING notification_id INTO v_notification_id; 

        INSERT INTO askLeic.answer_notification (notification_id, answer_id, vote_id)
        VALUES (v_notification_id, p_item_id, v_vote_id);  
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        
        RAISE;  
END;
$$ LANGUAGE plpgsql;


-- transaction to send a notification when a answer is verified
CREATE OR REPLACE FUNCTION verify_answer_and_notify(
    p_answer_id INTEGER  
) 
RETURNS VOID AS $$
DECLARE
    v_author_id INTEGER;          
    v_notification_id INTEGER;                                                                                                                                                                                      
BEGIN
    -- Update the answer to set it as verified and get the author ID
    SELECT author_id INTO v_author_id
    FROM askLeic.answer
    WHERE answer_id = p_answer_id;

    -- Ensure an answer was found and updated
    IF NOT FOUND THEN
        RAISE EXCEPTION 'Answer with ID % not found or cannot be verified.', p_answer_id;
    END IF;

    -- Update the verified status
    UPDATE askLeic.answer
    SET verified = TRUE, edited_date = CURRENT_TIMESTAMP
    WHERE answer_id = p_answer_id;

    -- Insert a notification for the author of the answer
    INSERT INTO askLeic.notification (date)
    VALUES (CURRENT_TIMESTAMP)
    RETURNING notification_id INTO v_notification_id; 

    -- Associate the notification with the author
    INSERT INTO askLeic.user_has_notification (user_id, notification_id)
    VALUES (v_author_id, v_notification_id);

EXCEPTION
    WHEN OTHERS THEN
        RAISE; 
END;
$$ LANGUAGE plpgsql;


-- transaction to when we delete a user
CREATE OR REPLACE FUNCTION delete_user_transaction(p_user_id INTEGER)
RETURNS VOID AS $$
DECLARE
    v_deleted_user_id INTEGER; 
BEGIN
    -- Check if the user exists
    PERFORM 1 FROM askLeic."user" WHERE user_id = p_user_id AND deleted = FALSE;
    IF NOT FOUND THEN
        RAISE EXCEPTION 'User with ID % does not exist or is already marked as deleted.', p_user_id;
    END IF;

    -- Mark user as deleted
    UPDATE askLeic."user"
    SET deleted = TRUE
    WHERE user_id = p_user_id;

    -- Maintain questions
    UPDATE askLeic.question
    SET author_id = COALESCE(v_deleted_user_id, author_id) 
    WHERE author_id = p_user_id;

    -- Maintain answers
    UPDATE askLeic.answer
    SET author_id = COALESCE(v_deleted_user_id, author_id) 
    WHERE answer_id IN (
        SELECT answer_id FROM askLeic.user_posts_answer WHERE user_id = p_user_id
    );

    RAISE NOTICE 'User with ID % marked as deleted, and data retention actions completed.', p_user_id;
EXCEPTION
    WHEN OTHERS THEN
        RAISE; -- Raise the error if something goes wrong
END;
$$ LANGUAGE plpgsql;