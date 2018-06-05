db.employers.createIndex( 
	{ name: "text", alias: "text" },
	{ default_language: "none" }
);
db.job.createIndex( 
	{ name: "text", alias: "text" },
	{ default_language: "none" }
);
db.skills.createIndex( 
	{ name: "text", alias: "text" },
	{ default_language: "none" }
);
