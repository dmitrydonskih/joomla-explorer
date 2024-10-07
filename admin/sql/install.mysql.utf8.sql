CREATE TABLE #__logicaldoc_configuration(
    idConfiguration INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50),
    username VARCHAR(50),
    password VARCHAR(200),
    url VARCHAR(100),    
    ldFolderID VARCHAR(50),
    accessLevel VARCHAR(7),
    accessPassword VARCHAR(200),
    icon int,
    size int,
    updateDate int,
    author int,
    version int,
    type int,
    showEntries int,
    PRIMARY KEY(idConfiguration)
);
