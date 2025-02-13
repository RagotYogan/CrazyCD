CREATE TABLE besoins (
    id_besoins char(36) PRIMARY KEY DEFAULT (gen_random_uuid ()),
    client varchar not null,
    libelle varchar not null,
    competence varchar not null
);

INSERT INTO besoins (id_besoins,client, libelle, competence) VALUES
    ('550e8400-e29b-41d4-a716-446655440000','test@test.com','TEST', 'IF');
