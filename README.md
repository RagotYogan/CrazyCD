# CrazyCD

# Dépôt du projet de l'équipe Nuh uh #

## Liste des membres ##

 - **BORTOLOTTI Florian** - AIL2
 - **BRITO Clément** - DWM2
 - **DUCHÊNE Eloi** - AIL2
 - **HAROUNA Laeticia** - AIL1
 - **KOLER Maxime** - DWM2
 - **RAGOT Yogan** - AIL1

## URL ##

- **Dépôt GitHub** : [https://github.com/RagotYogan/CrazyCD]
- **Application finale** : http://docketu.iutnc.univ-lorraine.fr:60000

## Partie application Web ##
- Le bouton Création Besoins envoie vers un formulaire pour créer un besoin.
- Le bouton Gestion Salaries permet d'ajouter un salarie ainsi que de le modifier, d'ajouter une compétence dans la base de donnée.
- Le bouton Liste Besoins permet d'afficher les besoins d'un client. 
### Liste des numéros de fonctionnalités implantées ###

1. Création d’un besoin
2. Affichage des besoins d’un client
3. Modification d’un besoin
5. Création d’un salarié (Admin)
6. Affichage des salariés (Admin)
7. Gestion des compétences (Admin)
8. Ajout d’une compétence lors de la saisie d’un salarié
10. Lancement des affectations et affichage des résultats (Admin)

### Commentaires additionnels ###

- **Authentification** : Pas implémentée.
- **Interface Admin** : Accessible sans authentification.
- **Données test** : fichiers CSV fournis.

## Partie Optimisation ##

### Description de l'algorithme ###

L'algorithme utilisé repose sur une **approche gloutonne** pour associer les salariés aux clients selon leurs compétences et besoins.

#### Déroulement général ####

1. Organisation des besoins des clients : Création d’un tableau `superTab` regroupant les clients selon leurs besoins.
2. Parcours des salariés et affectation : Tri décroissant des différentes compétences des salariés et affectation prioritaire aux clients ayant un besoin correspondant si possible.
3. Mise à jour des affectations : Un salarié est affecté à un seul besoin et un client est retiré du tableau `superTab` une fois son besoin satisfait.
4. Les affectations ainsi créées sont stockées dans un tableau nommé `affectations`.

#### Implémentation de l’algorithme en PHP ####

```php
public function affecter(array $salaries, array $clients): void {
    $superTab = [];
    foreach ($clients as $client) {
        $besoins = $client->getBesoins();
        $first = true;
        foreach ($besoins as $besoin => $affect) {
            if (!isset($superTab[$besoin])) {
                $superTab[$besoin] = [];
            }
            if ($first) {
                array_unshift($superTab[$besoin], $client);
                $first = false;
            } else {
                $superTab[$besoin][] = $client;
            }
        }
    }
    usort($salaries, function ($a, $b) {
    	return count($a->competences) - count($b->competences);
    });
    foreach ($salaries as $salarie) {
        $salarie->trierTabComp();
        while(!$salarie->getAffecte()){
            for ($i = 0; $i < count($superTab); $i++) {
                if ($i == count($salarie->competences ) || $salarie->getAffecte()){
                    break;
                }
                $type = array_keys($salarie->competences)[$i];
                if (!empty($superTab[$type])){
                    $this->affectations[] = [$salarie, $type, $superTab[$type][0]];
                    $salarie->setAffecte(true);
                    $superTab[$type][0]->setBesoinAffecte($type);
                    array_shift($superTab[$type]);
                }
            }
            break;
        }
    }
}
```
### Justification des choix ###

- **Structure `superTab`** : 
  - `superTab` est une structure de données clé-valeur où : 
    - La **clé** représente un type de besoin spécifique. 
    - La **valeur** est une liste ordonnée des clients ayant ce besoin. 
  - L'organisation en tableau associatif permet une **recherche efficace** des clients nécessitant une compétence donnée et optimise le processus d'affectation. 

- **Tri des différentes compétences des salariés** : 
  - Chaque salarié possède une liste de compétences triée pour prioriser l'affectation aux besoins les plus adaptés à ses compétences. 
  
### Résultats ###
- Les résultats sont stockés dans un tableau, 
- Le calcul de score se fait par la méthode `calculerScore`, et donne un score chiffré de l'affectation, ce qui    permet d'évaluer l'algorithme.

## Déploiement ##

### Méthode utilisée ###

1. **Mise en place de l’environnement** :
   - Développement en PHP avec une base de données MySQL.
   - Interface web en Vue.js pour l’interaction utilisateur.
2. **Exécution de l’algorithme** :
   - 

---

