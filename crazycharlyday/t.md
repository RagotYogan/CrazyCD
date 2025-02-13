# Crazy Charly Day - Rapport

## Équipe Nuh uh
**Membres** :  
- BORTOLOTTI Florian  
- BRITO Clément  
- DUCHÊNE Eloi  
- HAROUNA Laeticia  
- KOLER Maxime  
- RAGOT Yogan  

## Dépôt Github
[CrazyCD Repository](https://github.com/RagotYogan/CrazyCD)

---

## 1. Description de l'algorithme
L'algorithme d'affectation implémenté repose sur un **algorithme glouton** permettant d'associer les salariés aux clients en fonction de leurs besoins et compétences.

### 1.1 Déroulement général
1. **Organisation des besoins des clients** :  
   Un tableau `superTab` est construit pour regrouper les clients selon leurs besoins spécifiques.
2. **Parcours des salariés et affectation** :  
   On trie les compétences des salariés et on les affecte aux clients en fonction de leurs besoins, en respectant l'ordre de priorité des compétences.
3. **Mise à jour des affectations** :  
   Un salarié est affecté à un seul besoin et un client est retiré dès que son besoin est comblé.
4. **Affichage des résultats et calcul du score global**.

### 1.2 Algorithme en PHP
```php
public function affecter(array $salaries, array $clients): void
{
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
    foreach ($salaries as $salarie) {
        $salarie->trierTabComp();
        while(!$salarie->getAffecte()){
            for ($i = 0; $i < count($superTab); $i++) {
                if ($i == count($salarie->competences) || $salarie->getAffecte()){
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
    foreach ($this->affectations as $affectation) {
        list($salarie, $besoin, $client) = $affectation;
        echo "Salarie: {$salarie->nom}, Besoin: {$besoin}, Client: {$client->nom}\n";
    }
    echo $this->calculerScore($this->affectations, $salaries, $clients);
}
