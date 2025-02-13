CREATE TABLE besoins (
    id_besoins char(36) PRIMARY KEY DEFAULT (gen_random_uuid ()),
    client varchar not null,
    libelle varchar not null,
    competence varchar not null
);

INSERT INTO besoins (id_besoins,client, libelle, competence) VALUES
    ('550e8400-e29b-41d4-a716-446655440000','test@test.com','TEST', 'IF');

DROP TABLE IF EXISTS "competence";
DROP SEQUENCE IF EXISTS commpetence_id_competence_seq;
CREATE SEQUENCE commpetence_id_competence_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."competence" (
                                       "id_competence" integer DEFAULT nextval('commpetence_id_competence_seq') NOT NULL,
                                       "nom" character(36),
                                       CONSTRAINT "commpetence_pkey" PRIMARY KEY ("id_competence")
) WITH (oids = false);

INSERT INTO "competence" ("id_competence", "nom") VALUES
                                                      (1,	'IF'),
                                                      (2,	'MN'),
                                                      (3,	'JD');

DROP TABLE IF EXISTS "salarie";
DROP SEQUENCE IF EXISTS salarie_id_salarie_seq;
CREATE SEQUENCE salarie_id_salarie_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."salarie" (
                                    "id_salarie" integer DEFAULT nextval('salarie_id_salarie_seq') NOT NULL,
                                    "nom" character(36) NOT NULL,
                                    CONSTRAINT "salarie_pkey" PRIMARY KEY ("id_salarie")
) WITH (oids = false);

INSERT INTO "salarie" ("id_salarie", "nom") VALUES
    (1,	'TOTO');