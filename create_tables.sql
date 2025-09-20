CREATE TABLE "Accounts" (
	"account_id"	INTEGER,
	"username"	TEXT UNIQUE,
    "password"	TEXT,
	"email"	TEXT UNIQUE,
	"account_type"	INTEGER,
	"email_code"	TEXT,
    "bio"   TEXT,
	PRIMARY KEY("account_id" AUTOINCREMENT)
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
    "blog_datetime" DATETIME,
    "visibility"    INTEGER,
    "title" TEXT,
    "contents"  TEXT,
    "blog_url"  TEXT UNIQUE,
    "iv"    TEXT,
    PRIMARY KEY("blog_id" AUTOINCREMENT),
    FOREIGN KEY("account_id")   REFERENCES "Accounts"("account_id")
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
    "blog_id"   INTEGER,
    "file_name" TEXT,
    "mime_type" TEXT,
    "file_url"  TEXT,
    PRIMARY KEY("file_id" AUTOINCREMENT),
    FOREIGN KEY("account_id")   REFERENCES "Accounts"("account_id"),
    FOREIGN KEY("blog_id")  REFERENCES "Blog_posts"("blog_id")
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