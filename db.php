<?php
include_once('database.php');


$query = mysql_query("CREATE TABLE IF NOT EXISTS t_sprav(id INT(11) NOT NULL AUTO_INCREMENT, 
                                   topic INT(11), 
                                   Text_values VARCHAR(30), 
                                   PRIMARY KEY (id))",$connect);

$insTSprav = "INSERT INTO t_sprav (topic, Text_values) VALUES(2,'open'),
															 (2,'in progress'),
															 (2,'closed'),
															 (2,'failed'),
															 (2,'verified'),
															 (2,'successes')"; 


mysql_query($insTSprav);


mysql_query("CREATE TABLE IF NOT EXISTS region_list(id INT(11) NOT NULL AUTO_INCREMENT, 
													name VARCHAR(30), 
													parent_id INT(11), 
													PRIMARY KEY (id),
													FOREIGN KEY (parent_id) REFERENCES region_list(id))",$connect);
$insRegion= "INSERT INTO region_list (name, parent_id) VALUES('Lvivska',NULL),
															 ('Lvivskiy',1),
															 ('Lviv',2),
															 ('Vinnitska',NULL),
															 ('Zhmerinskiy',4),
															 ('Zhmerinka',5),
															 ('Kuivska',NULL),
															 ('Kuivskiy',7),
															 ('Kuiv',8),
															 ('Vinnitska',NULL),
															 ('Vinnitskiy',10),
															 ('Vinnitsa',11),
															 ('Chernivetska',NULL),
															 ('Chernivetskiy',13),
															 ('Chernivtsi',14)"; 

mysql_query($insRegion);


mysql_query("CREATE TABLE IF NOT EXISTS userlist(id_u INT(11) NOT NULL AUTO_INCREMENT, 
                                    name VARCHAR(30), 
                                    login VARCHAR(30), 
                                    pass VARCHAR(30), 
                                    city INT(11), 
                                    PRIMARY KEY (id_u),
                                    FOREIGN KEY (city) REFERENCES region_list(id))",$connect);										
$insUser = "INSERT INTO userlist (name, login, pass, city) VALUES('Mike','mike','pass',3),
																('Luna','luna','pass1',6),
																('Nick','nick','pass2',9),
																('Serg','serg','pass3',12),
																('Helen','helen','pass4',15),
																('Jim','jim','pass5',12),
																('Rich','rich','pass6',9),
																('Tom','tom','pass7',6),
																('Sara','sara','pass8',3),
																('Ana','ana','pass9',6),
																('Patric','patric','pass10',9),
																('Jessy','jessy','pass11',12),
																('Simba','simba','pass12',15),
																('Jira','jira','pass13',12),
																('Lana','lana','pass14',9)";

mysql_query($insUser);


mysql_query("CREATE TABLE IF NOT EXISTS goods(id INT(11) NOT NULL AUTO_INCREMENT, 
											id_user INT(11), 
											tema VARCHAR(30), 
											meil VARCHAR(50), 
											Statys_m INT(11), 
											PRIMARY KEY (id),
											FOREIGN KEY (id_user) REFERENCES userlist(id_u),
											FOREIGN KEY (Statys_m) REFERENCES t_sprav(id))",$connect);
$insGoods = "INSERT INTO goods (id_user, tema, meil, Statys_m) VALUES(5,'About','something',1),
																     (8,'New','trip',2),
																     (10,'Meating','group',3),
																	 (1,'Good','things',4),
																	 (15,'Rich','clients',5),
																	 (2,'Good','moon',6),
																	 (6,'Raining','now',5),
																	 (3,'Something','nice',4),
																	 (4,'Greeting','to',3),
																	 (7,'Lonely','day',2),
																	 (9,'Summer','hot',1),
																	 (11,'Night','dark',2),
																	 (12,'Winter','near',3),
																	 (13,'Tricky','mouse',4),
																	 (14,'Good','time',5)"; 

mysql_query($insGoods);
?>