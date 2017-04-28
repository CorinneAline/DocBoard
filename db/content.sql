insert into author values (1, 'Georges', 'Orwell');
insert into author values (2, 'James', 'Ellroy');

insert into book values
(1, '1984', '2-07-036822-X', '1984 (Nineteen Eighty-Four) est le plus célèbre roman de George Orwell, publié en 1949. Il décrit une Grande-Bretagne trente ans après une guerre nucléaire entre l''Est et l''Ouest censée avoir eu lieu dans les années 1950 et où s''est instauré un régime de type totalitaire fortement inspiré à la fois du stalinisme et de certains éléments du nazisme.', 1);
insert into book values
(2, 'La Ferme des animaux', '2-07-037516-1', 'La Ferme des animaux (Animal Farm) est un roman de George Orwell publié en 1945, décrivant une ferme dans laquelle les animaux se révoltent puis prennent le pouvoir et chassent les hommes.', 1);
insert into book values
(3, 'Le Dahlia noir', '2-86930-153-7', 'Le Dahlia noir (The Black Dahlia) est un roman policier historique américain de James Ellroy paru en 1987, inspiré de l''affaire du Dahlia noir. Le roman mêle un fait divers réel : la mort d''une jeune femme, Elizabeth Short, à une fiction romanesque : le destin de deux amis, flics du LAPD qui enquêtent sur ce crime.', 2);

/* raw password is 'john' */
insert into t_user values
(1, 'JohnDoe', 'L2nNR5hIcinaJkKR+j4baYaZjcHS0c3WX2gjYF6Tmgl1Bs+C9Qbr+69X8eQwXDvw0vp73PrcSeT0bGEW5+T2hA==', 'YcM=A$nsYzkyeDVjEUa7W9K', 'ROLE_USER');
/* raw password is 'jane' */
insert into t_user values
(2, 'JaneDoe', 'EfakNLxyhHy2hVJlxDmVNl1pmgjUZl99gtQ+V3mxSeD8IjeZJ8abnFIpw9QNahwAlEaXBiQUBLXKWRzOmSr8HQ==', 'dhMTBkzwDKxnD;4KNs,4ENy', 'ROLE_USER');
/* raw password is '@dm1n' */
insert into t_user values
(3, 'admin', 'gqeuP4YJ8hU3ZqGwGikB6+rcZBqefVy+7hTLQkOD+jwVkp4fkS7/gr1rAQfn9VUKWc7bvOD7OsXrQQN5KGHbfg==', 'EDDsl&fBCJB|a5XUtAlnQN8', 'ROLE_ADMIN');

insert into t_link values
(1, "Les « dev » ces nouvelles stars que l'on s'arrache", 'http://www.lesechos.fr/journal20141121/lec1_enquete/0203908469986-les-dev-ces-nouvelles-stars-que-lon-sarrache-1066627.php', 1);
insert into t_link values
(2, 'The state of JavaScript in 2015', 'http://www.breck-mckye.com/blog/2014/12/the-state-of-javascript-in-2015/', 1);
insert into t_link values
(3, "Guide d'autodéfense numérique", 'http://guide.boum.org/', 2);
insert into t_link values
(4, 'Controverse du GamerGate', 'http://fr.wikipedia.org/wiki/Controverse_du_Gamergate', 2);

insert into t_article values
(1, 'First article', 'Hi there! This is the very first article.');
insert into t_article values
(2, 'Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit mauris ac porttitor accumsan. Nunc vitae pulvinar odio, auctor interdum dolor. Aenean sodales dui quis metus iaculis, hendrerit vulputate lorem vestibulum. Suspendisse pulvinar, purus at euismod semper, nulla orci pulvinar massa, ac placerat nisi urna eu tellus. Fusce dapibus rutrum diam et dictum. Sed tellus ipsum, ullamcorper at consectetur vitae, gravida vel sem. Vestibulum pellentesque tortor et elit posuere vulputate. Sed et volutpat nunc. Praesent nec accumsan nisi, in hendrerit nibh. In ipsum mi, fermentum et eleifend eget, eleifend vitae libero. Phasellus in magna tempor diam consequat posuere eu eget urna. Fusce varius nulla dolor, vel semper dui accumsan vitae. Sed eget risus neque.');
insert into t_article values
(3, 'Lorem ipsum in french', "J’en dis autant de ceux qui, par mollesse d’esprit, c’est-à-dire par la crainte de la peine et de la douleur, manquent aux devoirs de la vie. Et il est très facile de rendre raison de ce que j’avance. Car, lorsque nous sommes tout à fait libres, et que rien ne nous empêche de faire ce qui peut nous donner le plus de plaisir, nous pouvons nous livrer entièrement à la volupté et chasser toute sorte de douleur ; mais, dans les temps destinés aux devoirs de la société ou à la nécessité des affaires, souvent il faut faire divorce avec la volupté, et ne se point refuser à la peine. La règle que suit en cela un homme sage, c’est de renoncer à de légères voluptés pour en avoir de plus grandes, et de savoir supporter des douleurs légères pour en éviter de plus fâcheuses.");

insert into t_comment values
(1, 'Great! Keep up the good work.', 1, 1);
insert into t_comment values
(2, "Thank you, I'll try my best.", 1, 2);