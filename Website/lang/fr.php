<?php

const LANG = [
    'error' => [
        'internal' => 'Désolé, votre action n\'a pas pu être réalisée à cause d\'une erreur interne.',
        'unknown' => [
            'title' => 'Erreur inconnue',
            'message' => 'Mh... Nous ne savons pas ce qu\'il s\'est passé. Si cette erreur se reproduit, veuillez nous contacter.'
        ],
        'code' => [
            '400' => [
                'title' => 'Requête invalide',
                'message' => 'Votre navigateur a envoyé une requête que notre serveur ne peut pas traiter.'
            ],
            '401' => [
                'title' => 'Authentification requise',
                'message' => 'Une authentification est nécessaire pour accéder à cette page.'
            ],
            '403' => [
                'title' => 'Accès interdit',
                'message' => 'Vous ne pouvez accéder à cette page.'
            ],
            '404' => [
                'title' => 'Page introuvable',
                'message' => 'Désolé, la page que vous recherchez n\'est plus disponible.'
            ],
            '405' => [
                'title' => 'Méthode de requête non autorisée',
                'message' => 'Vous avez utilisé une méthode de requête non autorisée.'
            ],
            '406' => [
                'title' => 'Non acceptable',
                'message' => 'Votre navigateur n\'accepte pas le type MIME de cette page.'
            ],
            '407' => [
                'title' => 'Authentification par proxy requise',
                'message' => 'Vous devez vous connecter à un proxy avant d\'accéder à cette page.'
            ],
            '412' => [
                'title' => 'Échec des préconditions',
                'message' => 'Préconditions envoyées par la requête non vérifiées.'
            ],
            '414' => [
                'title' => 'URI trop longue',
                'message' => 'L\'URI que vous avez utilisé est trop longue pour le serveur.'
            ],
            '415' => [
                'title' => 'Type du media non supporté',
                'message' => 'Le serveur ne peut pas traiter votre requête.'
            ],
            '418' => [
                'title' => 'Je suis un chien',
                'message' => 'Waf waf.'
            ],
            '500' => [
                'title' => 'Erreur interne',
                'message' => 'Désolé, le serveur a rencontré une erreur pendant l\'execution de votre requête.'
            ],
            '501' => [
                'title' => 'Non supporté',
                'message' => 'Le serveur ne peut pas prendre en charge votre requête.'
            ],
            '502' => [
                'title' => 'Bad gateway',
                'message' => 'Le serveur ne peut pas traiter votre requête.'
            ],
            '503' => [
                'title' => 'Maintenance',
                'message' => 'Nous revenons bientôt !'
            ],
        ],
        'input' => [
            'username' => [
                'empty' => 'Le nom d\'utilisateur ne peut pas être vide.',
                'tooShort' => 'Le nom d\'utilisateur doit contenir au moins ' . MIN_USERNAME_SIZE . ' caractères.',
                'tooLong' => 'Le nom d\'utilisateur ne peut pas dépasser ' . MAX_USERNAME_SIZE . ' caractères.',
                'invalid' => 'Le format du nom d\'utilisateur n\'est pas valide.',
                'taken' => 'Ce nom d\'utilisateur est déjà utilisé.',
                'server' => 'Nos serveurs sont actuellement dans l\'incapacité de vérifier la validité de votre nom d\'utilisateur. Si le problème persiste, nous vous remercions de contacter le support.'
            ],
            'email' => [
                'empty' => 'L\'adresse mail ne peut pas être vide.',
                'tooShort' => 'L\'adresse mail doit contenir au moins ' . MIN_EMAIL_SIZE . ' caractères.',
                'tooLong' => 'L\'adresse mail ne peut pas dépasser ' . MAX_EMAIL_SIZE . ' caractères.',
                'invalid' => 'Le format de l\'adresse mail n\'est pas valide.',
                'taken' => 'Cette adresse mail est déjà utilisée.',
                'server' => 'Désolé, nos serveurs sont actuellement dans l\'incapacité de vérifier la validité de votre adresse mail. Si le problème persiste, nous vous remercions de contacter le support.'
            ],
            'password' => [
                'empty' => 'Le mot de passe ne peut pas être vide.',
                'tooShort' => 'Le mot de passe doit contenir au moins ' . MIN_PASSWORD_SIZE . ' caractères.',
                'tooLong' => 'Le mot de passe ne peut pas dépasser ' . MAX_PASSWORD_SIZE . ' caractères.',
                'confirmDifferent' => 'Ce mot de passe est différent de celui que vous avez renseigné plus haut.'
            ]
        ]
    ],
    'months' => [
        '01' => 'janvier',
        '02' => 'février',
        '03' => 'mars',
        '04' => 'avril',
        '05' => 'mai',
        '06' => 'juin',
        '07' => 'juillet',
        '08' => 'août',
        '09' => 'septembre',
        '10' => 'octobre',
        '11' => 'novembre',
        '12' => 'décembre',
    ],
    'nav' => [
        'search' => [
            'placeholder' => 'Rechercher une oeuvre, un auteur...',
            'toggleMobileSearch' => 'Commencer une recherche...'
        ],
        'profile' => [
            'notConnected' => [
                'icon' => 'Non connecté'
            ],
            'connected' => [
                'icon' => 'Votre photo de profil',
                'dropdown' => 'Afficher le menu',
                'write' => 'Écrire',
                'profile' => 'Mon profil',
                'works' => 'Mes oeuvres',
                'favorites' => 'Mes favoris',
                'settings' => 'Paramètres',
                'logout' => [
                    'name' => 'Se déconnecter',
                    'title' => 'Déconnexion',
                    'close' => 'Annuler la déconnexion',
                    'message' => 'Voulez-vous vous déconnecter de Publicat ? Vous serez redirigé vers l\'accueil après ça.',
                    'confirm' => 'Se déconnecter',
                    'success' => 'Vous avez été déconnecté avec succès. À bientôt !'
                ]
            ]
        ],
        'connect' => [
            'login' => 'Se connecter',
            'register' => 'S\'inscrire'
        ]
    ],
    'mobileMenu' => [
        'close' => 'Fermer le menu',
        'title' => 'Profil',
        'notConnected' => [
            'books' => 'Déconnecté',
            'text' => 'Vous devez vous connecter pour accéder à votre profil.',
            'login' => 'Se connecter',
            'register' => 'S\'inscrire'
        ]
    ],
    'input' => [
        'username' => [
            'name' => 'Nom d\'utilisateur',
            'placeholder' => 'Entrez un nom d\'utilisateur',
            'obligations' => [
                'title' => 'Exigences pour le nom d\'utilisateur :',
                'values' => [
                    'Doit être entre 5 et 30 caractères',
                    'Ne doit pas avoir d\'espaces',
                    'Doit être uniquement constitué de chiffres et de lettres',
                    'Peut contenir des underscores et des points, mais pas au début, à la fin, ni l\'un après l\'autre (exemple : super_cat.70)'
                ]
            ]
        ],
        'email' => [
            'name' => 'Adresse mail',
            'placeholder' => 'Entrez une adresse mail'
        ],
        'password' => [
            'name' => 'Mot de passe',
            'placeholder' => 'Entrez un mot de passe',
            'strength' => [
                'tooRisky' => 'Très risqué',
                'risky' => 'Risqué',
                'correct' => 'Correct',
                'strong' => 'Fort',
                'veryStrong' => 'Très fort'
            ],
            'obligations' => 'Votre mot de passe doit contenir entre ' . MIN_PASSWORD_SIZE . ' et ' . MAX_PASSWORD_SIZE . ' caractères. Nous vous recommandons l\'utilisation de caractères spéciaux, de chiffres et de majuscules pour un mot de passe fort.',
            'toggle' => [
                'show' => 'Voir',
                'hide' => 'Cacher'
            ]
        ],
        'passwordConfirm' => [
            'name' => 'Confirmation du mot de passe',
            'placeholder' => 'Confirmez le mot de passe'
        ],
        'tos' => 'J\'ai lu et j\'accepte les conditions générales d\'utilisation et les politiques de confidentialité de Publicat.'
    ],
    'form' => [
        'signIn' => [
            'title' => 'Rejoindre Publicat',
            'description' => 'Créez un compte et devenez un membre actif de la communauté de lecteurs et d\'écrivains.',
            'submit' => 'Créer mon compte',
            'notification' => 'Bienvenue sur Publicat, %s !'
        ],
        'login' => [
            'title' => 'Bon retour parmis nous !',
            'submit' => 'Se connecter',
            'error' => [
                'mail' => 'Cette adresse mail n\'existe pas dans notre base de données.',
                'password' => 'Mot de passe incorrect.'
            ],
            'notification' => 'Bon retour parmis nous, %s !'
        ]
    ],
    'home' => [
        'title' => [
            'connected' => 'Accueil - Publicat',
            'notConnected' => 'Bienvenue sur Publicat'
        ]
    ],
    'userprofile' => [
        'notFound' => [
            'title' => 'Utilisateur introuvable',
            'message' => 'Cet utilisateur n\'existe pas sur Publicat.'
        ],
        'title' => '@%s sur Publicat',
        'banner' => [
            'alt' => 'Bannière de %s'
        ],
        'picture' => [
            'alt' => 'Photo de profil de %s'
        ],
        'verified' => 'Profil vérifié',
        'follow' => [
            'name' => 'Suivre',
            'error' => 'Une erreur s\'est produite en essayant de suivre %s.',
            'success' => 'Vous suivez désormais %s.'
        ],
        'following' => [
            'name' => 'Suivi(e)'
        ],
        'unfollow' => [
            'name' => 'Ne plus suivre',
            'error' => 'Une erreur s\'est produite en essayant de se désabonner de %s.',
            'success' => 'Vous ne suivez plus %s.'
        ],
        'settings' => 'Modifier',
        'infos' => [
            'followers' => [
                'singular' => 'abonné',
                'plural' => 'abonnés'
            ],
            'following' => [
                'singular' => 'abonnement',
                'plural' => 'abonnements'
            ],
            'works' => [
                'singular' => 'oeuvre',
                'plural' => 'oeuvres'
            ],
            'joined' => 'À rejoint le %s'
        ],
        'works' => [
            'title' => 'Publications',
            'none' => [
                'alt' => 'Aucune publication',
                'message' => '%s n\'a pas de publications à son actif.'
            ]
        ]
    ],
    'usersettings' => [
        'title' => 'Paramètres (Profil et compte) - Publicat',
        'sectionTitle' => 'Paramètres : profil et compte',
        'success' => 'Vos modifications ont bien été prises en compte !',
        'error' => 'Une erreur interne est survenue lors de votre modification.',
        'profile' => [
            'title' => 'Mon profil',
            'displayName' => [
                'label' => 'Nom',
                'placeholder' => 'Comment voulez-vous qu\'on vous appelle ?',
                'invalid' => 'Votre nom doit contenir entre ' . MIN_DISPLAY_NAME_SIZE . ' et ' . MAX_DISPLAY_NAME_SIZE . ' caractères.',
            ],
            'aboutMe' => [
                'label' => 'Biographie',
                'placeholder' => 'Parlez de vous !',
                'invalid' => 'Votre biographie doit contenir entre ' . MIN_ABOUT_ME_SIZE . ' et ' . MAX_ABOUT_ME_SIZE . ' caractères.',
            ],
            'birthdate' => [
                'label' => 'Date de naissance',
                'warning' => 'Attention, après avoir mis pour la première fois une date de naissance, vous ne pourrez plus la retirer.',
                'invalid' => [
                    'format' => 'Le format de la date n\'est pas valide.',
                    'thisYear' => 'Votre année de naissance ne peut pas être la même que cette année.',
                    'aboveThisYear' => 'Waw, on a toujours voulu rencontrer un voyageur du temps ! Si vous voulez discuter pour nous raconter votre époque, contactez nous.',
                    'tooOld' => 'Félicitations, vous êtes la personne la plus agée sur terre !'
                ]
            ],
            'submit' => 'Sauvegarder'
        ],
        'pictures' => [
            'title' => 'Identité graphique',
            'message' => 'Vous pouvez envoyer des images au format PNG ou JPEG, sans dépasser les 2 MB. Pour supprimer une image, laisser le champ vide. Les images doivent être conformes aux règles de sécurité de Publicat.',
        ],
        'picture' => [
            'label' => 'Envoyer une nouvelle photo de profil',
            'alt' => 'Votre photo de profil',
            'submit' => 'Envoyer',
            'error' => [
                'internal' => 'Une erreur interne est survenue lors de l\'envoi de votre photo de profil.',
                'size' => 'Votre image est trop grande !',
                'extension' => 'Le format de votre image n\'est pas conforme.'
            ],
            'success' => [
                'remove' => 'Votre photo de profil a bien été supprimée.',
                'upload' => 'Votre photo de profil a bien été mise à jour.'
            ],
            'delete' => [
                'close' => 'Annuler',
                'title' => 'Supprimer ma photo de profil',
                'message' => 'Voulez-vous supprimer votre photo de profil ? Cette action est irréversible et vous aurez de nouveau une photo par défaut.',
                'deleteButton' => 'Confirmer'
            ]
        ],
        'banner' => [
            'label' => 'Envoyer une nouvelle bannière',
            'alt' => 'Votre bannière',
            'submit' => 'Envoyer',
            'error' => [
                'internal' => 'Une erreur interne est survenue lors de l\'envoi de votre bannière.',
                'size' => 'Votre image est trop grande !',
                'extension' => 'Le format de votre image n\'est pas conforme.'
            ],
            'success' => [
                'remove' => 'Votre bannière a bien été supprimée.',
                'upload' => 'Votre bannière a bien été mise à jour.'
            ],
            'delete' => [
                'close' => 'Annuler',
                'title' => 'Supprimer ma bannière',
                'message' => 'Voulez-vous supprimer votre bannière ? Cette action est irréversible et vous aurez de nouveau une bannière par défaut.',
                'deleteButton' => 'Confirmer'
            ]
        ],
        'account' => [
            'title' => 'Mon compte',
            'submit' => 'Sauvegarder',
            'username' => [
                'label' => 'Nom d\'utilisateur',
                'placeholder' => 'Nom d\'utilisateur'
            ],
            'email' => [
                'label' => 'Adresse mail',
                'placeholder' => 'Adresse mail'
            ]
        ],
        'password' => [
            'title' => 'Modifier mon mot de passe',
            'oldPassword' => [
                'label' => 'Mot de passe actuel',
                'placeholder' => 'Entrez votre mot de passe actuel',
                'empty' => 'Veuillez confirmer votre mot de passe actuel pour pouvoir le changer.',
                'incorrect' => 'Mot de passe incorrect.'
            ],
            'newPassword' => [
                'label' => 'Nouveau mot de passe',
                'placeholder' => 'Entrez un nouveau mot de passe',
                'empty' => 'Votre nouveau mot de passe ne peut pas être vide.',
                'format' => 'Le format de votre mot de passe n\'est pas valide.'
            ],
            'success' => 'Votre mot de passe a été mis à jour avec succès !'
        ],
        'dangerZone' => [
            'title' => 'Modifications permanentes',
            'description' => 'Les actions suivantes peuvent entrainer des changements permanents sur votre compte. Manipulez avec prudence !',
            'delete' => [
                'title' => 'Supprimer mon compte',
                'close' => 'Annuler la suppression',
                'message' => 'Voulez-vous vraiment supprimer votre compte ? Cette action est irréversible et vous ne pourrez plus récupérer vos données une fois cette action effectuée.',
                'deleteButton' => 'Oui, au revoir !',
                'confirmMessage' => 'Votre compte a été supprimé avec succès, au revoir !',
                'error' => 'Une erreur est survenue lors de la suppression de votre compte. Veuillez contacter le support si ce problème persiste.'
            ],
            'revokePermissions' => [
                'title' => 'Renoncer à mes droits Admin./Mod.',
                'close' => 'Annuler la procédure',
                'message' => 'Attention, vous vous apprêtez à renoncer à tous vos droits administrateur et modérateur sur Publicat. Cette mesure doit uniquement être utilisée si vous pensez que l\'accès à votre compte a été compromis. Après confirmation, ce compte retrouvera les permissions par défaut. Voulez-vous continuer ?',
                'revokeButton' => 'Renoncer à mes droits',
                'confirmMessage' => 'Rôle supprimé.',
                'error' => 'Erreur interne'
            ]
        ]
    ]
];

















