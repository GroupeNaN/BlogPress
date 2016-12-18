# BlogPress

Auteurs : Léonard Benedetti et Émile-Hugo Spir

Déploiement : http://blogpress.mlpo.fr/

BlogPress est une application web simple — mais complète — qui permet de gérer un petit blog. Elle est développée avec Symfony et vise à illustrer les possibilités offertes par ce framework.

## Fonctionalités

### Accueil

La page d’accueil permet d’accéder à l’ensemble des articles publiés.

<img src="https://luna.mlpo.fr/img/home.png" width="450" style="border:1px solid gray; margin: 2px;" />

### Gestion des articles

Les pages des articles permettent d’accéder aux différentes informations contenues dans ces derniers (auteur, date de publication, contenu, catégories, etc.).

En fonction des droits de l’utilisateur connecté, plusieurs actions peuvent être proposées :
* Publier un nouvel article
* Modifier un article
* Supprimer un article

<img src="https://luna.mlpo.fr/img/article.png" width="450" style="border:1px solid gray; margin: 2px;" />
<img src="https://luna.mlpo.fr/img/add_article.png" width="450" style="border:1px solid gray; margin: 2px;" />
<img src="https://luna.mlpo.fr/img/delete_article.png" width="450" style="border:1px solid gray; margin: 2px;" />

### Gestion des commentaires (Many-to-One)

Les utilisateurs connectés ont la possibilité de laisser des commentaires sur chacun des articles publiés.

En fonction des droits de l’utilisateur connecté, il sera simplement possible de publier un commentaire ou de modérer ceux déjà publiés.

<img src="https://luna.mlpo.fr/img/comment.png" width="450" style="border:1px solid gray; margin: 2px;" />

### Gestion des catégories (Many-to-Many)

Chaque article publié est lié à zéro, une ou plusieurs catégories existantes. Il est ainsi possible d’effectuer des recherches d’articles publiés dans des catégories en particulier.

En fonction des droits de l’utilisateur connecté, l’utilisateur peut avoir la possibilité de créer ou de supprimer des catégories.

<img src="https://luna.mlpo.fr/img/categories.png" width="450" style="border:1px solid gray; margin: 2px;" />
<img src="https://luna.mlpo.fr/img/category.png" width="450" style="border:1px solid gray; margin: 2px;" />

### Utilisateurs

* Inscription d’un nouvel utilisateur
* Connexion d’un utilisateur (avec éventuellement un cookie « se rappeler de moi »)
* Gestion sommaire des droits (utilisateur standard, administrateur)

<img src="https://luna.mlpo.fr/img/login.png" width="450" style="border:1px solid gray; margin: 2px;" />
<img src="https://luna.mlpo.fr/img/register.png" width="450" style="border:1px solid gray; margin: 2px;" />

### API REST

Par ailleurs, toutes les ressources de cette application web sont accessibles à l’aide d’une API REST détaillée ci-dessous.

`GET /api/articles.json`

```
[
    {
        "id": 1,
        "title": "[…]",
        "subtitle": "[…]",
        "author": {
            "username": "admin"
        },
        "background": "[…]",
        "date": "2016-12-17T17:25:00+00:00",
        "content": "[…]",
        "comments": […],
        "categories": [
            {
                "id": 1,
                "name": "[…]"
            },
            […]
        ]
    },
    […]
]
```

`GET /api/article/{id}.json`

```
[
    "id": 1,
    "title": "[…]",
    "subtitle": "[…]",
    "author": {
        "username": "admin"
    },
    "background": "[…]",
    "date": "2016-12-17T17:25:00+00:00",
    "content": "[…]",
    "comments": […],
    "categories": [
        {
            "id": 1,
            "name": "[…]"
        },
        […]
    ]
]
```

`GET /api/categories.json`

```
[
    {
        "id": 1,
        "name": "[…]"
    },
    {
        "id": 2,
        "name": "[…]"
    },
    {
        "id": 3,
        "name": "[…]"
    }
]
```

`GET /api/category/{id}.json`

```
[
    "id": […],
    "title": "[…]",
    "subtitle": "[…]",
    "author": {
        "username": "admin"
    },
    "background": "[…]",
    "date": "2016-12-17T17:25:00+00:00",
    "content": "[…]",
    "comments": […],
    "categories": [
        {
            "id": {id},
            "name": "[…]"
        },
        […]
    ]
]
```

## Technologies

* [Symfony 3](https://symfony.com/)
* Template [Clean Blog](https://startbootstrap.com/template-overviews/clean-blog/) (basée sur Bootstrap)

## Spécifications

[✓] Site déployé (http://blogpress.mlpo.fr/)<br />
[✓] Le site répond à des requêtes en HTML et en JSON<br />
[✓] Utilisation de trois types d’associations différentes entre modèles (One-to-One, Many-to-One, Many-to-Many)<br />
[✓] Une base de données qui peut-être modifiée directement (migrate, rollback, etc.)<br />
[✓] Code disponible sur GitHub<br />
[✓] DRY friendly<br />
[✓] Rendu graphique propre Bootstrap (même si subjectif) et JSON propres (bien formatés)<br />

## Bonus

[✓] Code de « qualité » (respect des conventions Symfony)<br />
[✓] Pas trop de commentaires, car la plupart du temps le code est suffisamment explicite

