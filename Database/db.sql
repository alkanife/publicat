# ---------------------------------
# Default prefix: p0bl1_
# ---------------------------------

# Delete previous database and create a new one
DROP DATABASE IF EXISTS publicat;
CREATE DATABASE IF NOT EXISTS publicat;
USE publicat;


# Create 'userRoles' table
CREATE TABLE p0bl1_userRoles(
                          id   Int Auto_increment NOT NULL,
                          name Varchar (10) NOT NULL,

                          CONSTRAINT userRoles_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

# Insert default values into userRoles
INSERT INTO p0bl1_userRoles (id, name)
VALUES (1, 'member'),
       (9845, 'mod'),
       (17456, 'admin');


# Create 'users' table
CREATE TABLE p0bl1_users(
                      id                                    Int Auto_increment NOT NULL,
                      username                              Varchar (30) NOT NULL UNIQUE,
                      emailAddress                          Varchar (200) NOT NULL UNIQUE,
                      birthdate                             Date,
                      registeredDateTime                    Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      password                              Text NOT NULL,
                      displayName                           Varchar (50),
                      aboutMe                               Varchar (160),
                      profilePicture                        Text,
                      bannerPicture                         Text,
                      isVerified                            Boolean not null DEFAULT 0,
                      role_id                               Int NOT NULL DEFAULT 1,

                      CONSTRAINT users_PK PRIMARY KEY (id),
                      CONSTRAINT users_userRoles_FK FOREIGN KEY (role_id) REFERENCES p0bl1_userRoles(id)
)ENGINE=InnoDB;


# Create 'workTags' table
CREATE TABLE p0bl1_workTags(
                        id   Int Auto_increment NOT NULL,
                        name Varchar (30) NOT NULL,

                        CONSTRAINT workTags_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

# Insert default values into workTags
INSERT INTO p0bl1_workTags (name)
VALUES ('fantasy'),
       ('horror'),
       ('romance'),
       ('thriller'),
       ('humor'),
       ('mystery'),
       ('action'),
       ('adventure'),
       ('dystopian'),
       ('sf'),
       ('suspense'),
       ('short'),
       ('history'),
       ('crime');


# Create 'workVisibilities' table
CREATE TABLE p0bl1_workVisibilities(
                               id   Int Auto_increment NOT NULL,
                               name Varchar (30) NOT NULL,

                               CONSTRAINT workVisibilities_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

# Insert default values into workTags
INSERT INTO p0bl1_workVisibilities (name)
VALUES ('public'),
       ('link_only'),
       ('private'),
       ('draft');


# Create 'contentRatings' table
CREATE TABLE p0bl1_contentRatings(
                              id   Int  Auto_increment  NOT NULL,
                              name Varchar (30) NOT NULL,

                              CONSTRAINT contentRatings_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

# Insert default values into contentRatings
INSERT INTO p0bl1_contentRatings (name)
VALUES ('all'),
       ('r12'),
       ('r16'),
       ('r18');


# Create 'works' table
CREATE TABLE p0bl1_works(
                      id                      Int  Auto_increment  NOT NULL,
                      name                    Varchar (60) NOT NULL,
                      description             Varchar (300),
                      coverPicture            Text,
                      creationDateTime        Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      owner_id                Int NOT NULL,
                      contentRating_id        Int NOT NULL DEFAULT 1,

                      CONSTRAINT works_PK PRIMARY KEY (id),

                      CONSTRAINT works_users0_FK FOREIGN KEY (owner_id) REFERENCES p0bl1_users(id),
                      CONSTRAINT works_contentRating1_FK FOREIGN KEY (contentRating_id) REFERENCES p0bl1_contentRatings(id)
)ENGINE=InnoDB;


# Create 'documents' table
CREATE TABLE p0bl1_documents(
                         id                 Int  Auto_increment  NOT NULL,
                         viewIndex          Int NOT NULL,
                         name               Varchar (60) NOT NULL,
                         description        Varchar (300),
                         isDraft            Boolean NOT NULL DEFAULT 1,
                         content            Text (60000),
                         creationDateTime   Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         work_id            Int NOT NULL,

                         CONSTRAINT documents_PK PRIMARY KEY (id),

                         CONSTRAINT documents_works_FK FOREIGN KEY (work_id) REFERENCES p0bl1_works(id)
)ENGINE=InnoDB;


# Create 'worksHaveTags' table
CREATE TABLE p0bl1_worksHaveTags(
                              tag_id       Int NOT NULL,
                              work_id      Int NOT NULL,

                              CONSTRAINT worksHaveTags_PK PRIMARY KEY (tag_id, work_id),

                              CONSTRAINT worksHaveTags_workTag_FK FOREIGN KEY (tag_id) REFERENCES p0bl1_workTags(id),
                              CONSTRAINT worksHaveTags_works0_FK FOREIGN KEY (work_id) REFERENCES p0bl1_works(id)
)ENGINE=InnoDB;


# Create 'usersLikesWorks' table
CREATE TABLE p0bl1_usersLikesWorks(
                                work_id   Int NOT NULL,
                                user_id   Int NOT NULL,

                                CONSTRAINT usersLikesWorks_PK PRIMARY KEY (work_id, user_id),

                                CONSTRAINT usersLikesWorks_works_FK FOREIGN KEY (work_id) REFERENCES p0bl1_works(id),
                                CONSTRAINT usersLikesWorks_users0_FK FOREIGN KEY (user_id) REFERENCES p0bl1_users(id)
)ENGINE=InnoDB;


# Create 'followers' table
CREATE TABLE p0bl1_followers(
                          follower_id    Int NOT NULL,
                          following_id   Int NOT NULL,

                          CONSTRAINT followers_PK PRIMARY KEY (follower_id, following_id),

                          CONSTRAINT followers_users_FK FOREIGN KEY (follower_id) REFERENCES p0bl1_users(id),
                          CONSTRAINT followers_users0_FK FOREIGN KEY (following_id) REFERENCES p0bl1_users(id)
)ENGINE=InnoDB;