CREATE TABLE "FileRoster" (
    "roster_id" INTEGER,
    PRIMARY KEY("roster_id" AUTOINCREMENT)
);

CREATE TABLE "Accounts" (
	"account_id"	INTEGER,
    "roster_id"     INTEGER,
	"username"	TEXT UNIQUE,
    "password"	TEXT,
	"email"	TEXT UNIQUE,
	"account_type"	INTEGER,
	"email_code"	TEXT,
    "bio"   TEXT,
	PRIMARY KEY("account_id" AUTOINCREMENT),
    FOREIGN KEY("roster_id")    REFERENCES "FileRoster"("roster_id")
);

CREATE TABLE "Mutes" (
    "account_1" INTEGER,
    "account_2" INTEGER,
    PRIMARY KEY("account_1","account_2"),
    FOREIGN KEY("account_1")    REFERENCES "Accounts"("account_id"),
    FOREIGN KEY("account_2")    REFERENCES "Accounts"("account_id")
);

CREATE TABLE "Suspensions" (
    "suspension_id" INTEGER,
    "account_id"    INTEGER,
    "start_date"    DATE,
    "end_date"  DATE,
    PRIMARY KEY("suspension_id" AUTOINCREMENT),
    FOREIGN KEY("account_id")   REFERENCES "Accounts"("account_id")
);

CREATE TABLE "Blog_posts" (
    "blog_id"   INTEGER,
    "account_id"    INTEGER,
    "roster_id"     INTEGER,
    "blog_datetime" DATETIME,
    "visibility"    INTEGER,
    "title" TEXT,
    "contents"  TEXT,
    "blog_url"  TEXT UNIQUE,
    "iv"    TEXT,
    PRIMARY KEY("blog_id" AUTOINCREMENT),
    FOREIGN KEY("account_id")   REFERENCES "Accounts"("account_id"),
    FOREIGN KEY("roster_id")    REFERENCES "FileRoster"("roster_id")
);

CREATE TABLE "Comments" (
    "comment_id"    INTEGER,
    "account_id"    INTEGER,
    "blog_id"   INTEGER,
    "contents"  TEXT,
    "comment_datetime"  DATETIME,
    "iv"    TEXT,
    PRIMARY KEY("comment_id" AUTOINCREMENT),
    FOREIGN KEY("account_id")   REFERENCES "Accounts"("account_id"),
    FOREIGN KEY("blog_id")  REFERENCES "Blog_posts"("blog_id")
);

CREATE TABLE "User_files" (
    "file_id"   INTEGER,
    "file_use"  TEXT,
    "account_id"    INTEGER,
    "roster_id"   INTEGER,
    "file_name" TEXT,
    "mime_type" TEXT,
    "file_url"  TEXT,
    PRIMARY KEY("file_id" AUTOINCREMENT),
    FOREIGN KEY("account_id")   REFERENCES "Accounts"("account_id"),
    FOREIGN KEY("roster_id")    REFERENCES "FileRoster"("roster_id")
);

CREATE TABLE "Tags" (
    "tag_id"    INTEGER,
    "tag_name"  TEXT UNIQUE,
    PRIMARY KEY("tag_id" AUTOINCREMENT)
);

CREATE TABLE "Blog_tags" (
    "blog_tag_id"   INTEGER,
    "blog_id"   INTEGER,
    "tag_id"    INTEGER,
    "tag_type"  TEXT,
    PRIMARY KEY("blog_tag_id" AUTOINCREMENT),
    FOREIGN KEY("blog_id")  REFERENCES "Blog_posts"("blog_id"),
    FOREIGN KEY("tag_id")   REFERENCES "Tags"("tag_id")
);

CREATE TABLE "Blog_reports" (
    "blog_report_id"    INTEGER,
    "blog_id"   INTEGER,
    "contents"  TEXT,
    "report_date"   DATE,
    "report_type"   TEXT,
    "explanation"   TEXT,
    "resolved_date" DATE,
    PRIMARY KEY("blog_report_id" AUTOINCREMENT),
    FOREIGN KEY("blog_id")  REFERENCES "Blog_posts"("blog_id")
);

CREATE TABLE "Comment_reports" (
    "comment_report_id" INTEGER,
    "comment_id"    INTEGER,
    "contents"  TEXT,
    "report_date"   DATE,
    "report_type"   TEXT,
    "explanation"   TEXT,
    "resolved_date"  DATE,
    PRIMARY KEY("comment_report_id" AUTOINCREMENT),
    FOREIGN KEY("comment_id")   REFERENCES "Comments"("comment_id")
);

CREATE TABLE "TrainersTable" (
    "trainer_id" INTEGER,
    "account_id" INTEGER,
    "trainer_name" TEXT,
    PRIMARY KEY("trainer_id" AUTOINCREMENT),
    FOREIGN KEY("account_id") REFERENCES "Accounts"("account_id")
);

CREATE TABLE "Horses" (
    "horse_id" INTEGER,
    "trainer_id" INTEGER,
    "horse_type" INTEGER,
    "stat_spark" INTEGER,
    "apt_spark" INTEGER,
    "roster_id" INTEGER,
    PRIMARY KEY("horse_id" AUTOINCREMENT),
    FOREIGN KEY("trainer_id") REFERENCES "TrainersTable"("trainer_id"),
    FOREIGN KEY("roster_id") REFERENCES "FileRoster"("roster_id")
);

CREATE TABLE "HorseStats" (
    "horse_stats_id" INTEGER,
    "horse_id" INTEGER,
    "rating" INTEGER,
    "fans" INTEGER,
    "epiphet" INTEGER,
    "horse_date" DATE,
    "major_wins" INTEGER,
    "career_scenario" INTEGER,
    "speed" INTEGER,
    "stamina" INTEGER,
    "power" INTEGER,
    "guts" INTEGER,
    "wit" INTEGER,
    "turf" INTEGER,
    "dirt" INTEGER,
    "sprint" INTEGER,
    "mile" INTEGER,
    "medium" INTEGER,
    "long" INTEGER,
    "front_runner" INTEGER,
    "pace_chaser" INTEGER,
    "late_surger" INTEGER,
    "end_closer" INTEGER,
    PRIMARY KEY("horse_stats_id" AUTOINCREMENT),
    FOREIGN KEY("horse_id") REFERENCES "Horses"("horse_id")
);

CREATE TABLE "Inspirations" (
    "inspiration_id" INTEGER,
    "child_id" INTEGER,
    "parent_id" INTEGER,
    PRIMARY KEY("inspiration_id" AUTOINCREMENT),
    FOREIGN KEY("child_id") REFERENCES "Horses"("horse_id"),
    FOREIGN KEY("parent_id") REFERENCES "Horses"("horse_id")
);

CREATE TABLE "RacesTable" (
    "race_id" INTEGER,
    "race_name" TEXT,
    "grade" INTEGER,
    "distance" INTEGER,
    "racecourse" INTEGER,
    "track_type" INTEGER,
    "direction" INTEGER,
    PRIMARY KEY("race_id" AUTOINCREMENT)
);

CREATE TABLE "SkillsTable" (
    "skill_id" INTEGER,
    "skill_name" TEXT,
    "skill_type" INTEGER,
    "skill_level" INTEGER,
    PRIMARY KEY("skill_id" AUTOINCREMENT)
);

CREATE TABLE "SupportCardsTable" (
    "support_card_id" INTEGER,
    "trainee_enum" INTEGER,
    "card_name" TEXT,
    "stat" INTEGER,
    "rarity" INTEGER,
    PRIMARY KEY("support_card_id" AUTOINCREMENT)
);

CREATE TABLE "CardsUsed" (
    "card_used_id" INTEGER,
    "support_card_id" INTEGER,
    "horse_id" INTEGER,
    "level" INTEGER,
    PRIMARY KEY("card_used_id" AUTOINCREMENT),
    FOREIGN KEY("support_card_id") REFERENCES "SupportCardsTable"("support_card_id"),
    FOREIGN KEY("horse_id") REFERENCES "Horses"("horse_id")
);

CREATE TABLE "RacesRan" (
    "race_ran_id" INTEGER,
    "race_id" INTEGER,
    "horse_id" INTEGER,
    "weather" INTEGER,
    "track_condition" INTEGER,
    "placement" INTEGER,
    "strategy" INTEGER,
    PRIMARY KEY("race_ran_id" AUTOINCREMENT),
    FOREIGN KEY("race_id") REFERENCES "RacesTable"("race_id"),
    FOREIGN KEY("horse_id") REFERENCES "Horses"("horse_id")
);

CREATE TABLE "SkillsOwned" (
    "skill_owned_id" INTEGER,
    "skill_id" INTEGER,
    "horse_id" INTEGER,
    PRIMARY KEY("skill_owned_id" AUTOINCREMENT),
    FOREIGN KEY("skill_id") REFERENCES "SkillsTable"("skill_id"),
    FOREIGN KEY("horse_id") REFERENCES "Horses"("horse_id")
);

CREATE TABLE "RaceSparks" (
    "race_spark_id" INTEGER,
    "race_id" INTEGER,
    "horse_id" INTEGER,
    "stars" INTEGER,
    PRIMARY KEY("race_spark_id" AUTOINCREMENT),
    FOREIGN KEY("race_id") REFERENCES "RacesTable"("race_id")
);

CREATE TABLE "SkillSparks" (
    "skill_spark_id" INTEGER,
    "skill_id" INTEGER,
    "horse_id" INTEGER,
    "stars" INTEGER,
    PRIMARY KEY("skill_spark_id" AUTOINCREMENT),
    FOREIGN KEY("skill_id") REFERENCES "SkillsTable"("skill_id")
);