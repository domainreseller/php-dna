<div align="center">  
  <a href="README-TR.md"   >   TR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/TR.png" alt="TR" height="20" /></a>  
  <a href="README.md"> | EN <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/US.png" alt="EN" height="20" /></a>  
   <a href="README-DE.md"> | DE <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/DE.png" alt="DE" height="20" /></a>  
  <a href="README-SA.md"> | SA <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/SA.png" alt="AR" height="20" /></a>  
  <a href="README-NL.md"> | NL <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/NL.png" alt="NL" height="20" /></a>  
  <a href="README-AZ.md"> | AZ <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/AZ.png" alt="AZ" height="20" /></a>  
  <a href="README-CN.md"> | CN <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/CN.png" alt="CN" height="20" /></a>  
  <a href="README-FR.md"> | FR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/FR.png" alt="FR" height="20" /></a>  
  <a href="README-IT.md"> | IT <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/IT.png" alt="IT" height="20" /></a>  
</div>

## Guide d'Installation et d'Intégration

### Exigences Minimales

- PHP7.4 ou supérieur (Recommandé 8.1)
- L'extension PHP SOAPClient doit être active.

### A) Utilisation Manuelle

Téléchargez les fichiers et examinez les exemples dans le dossier [examples](examples).

```php
require_once __DIR__.'/src/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### B) Pour l'intégration avec Composer

```bash
composer require domainreseller/php-dna 
```

```php
require_once __DIR__.'/vendor/autoload.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### Utilisation

#### Opérations d'Enregistrement de Domaine

Note : Des paramètres supplémentaires sont requis pour les domaines .tr. Le paramètre Additional est utilisé pour les noms de domaine qui nécessitent des informations supplémentaires comme .tr.

```php
$contact = [
    "FirstName"        => 'John',
    "LastName"         => 'Doe',
    "Company"          => 'Example Corp',
    "EMail"            => 'john.doe@example.com',
    "AddressLine1"     => '123 Lorem Street',
    "AddressLine2"     => 'Suite 456',
    "AddressLine3"     => '',
    "City"             => 'Springfield',
    "Country"          => 'US',
    "Fax"              => '1234567890',
    "FaxCountryCode"   => '1',
    "Phone"            => '9876543210',
    "PhoneCountryCode" => 1,
    "Type"             => 'Contact',
    "ZipCode"          => '12345',
    "State"            => 'IL'
];

$a->RegisterWithContactInfo(
    'example.com',
    1,
    [
        'Administrative' => $contact,
        'Billing'        => $contact,
        'Technical'      => $contact,
        'Registrant'     => $contact
    ],
    ["ns1.example.com", "ns2.example.com"],
    true,
    false,
    //Les attributs Additional ne sont requis que pour les domaines .tr.
    [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '12345678901',
        'TRABISNAMESURNAME'    => 'John Doe',
        'TRABISCOUNTRYID'      => '840',
        'TRABISCITYID'        => '17'
    ]);
```

<details>
<summary>Exemple de Sortie pour l'Enregistrement de Domaine</summary>

```php
Array
(
    [result] => OK
    [data] => Array
    (
        [ID] => 123456
        [Status] => clientTransferProhibited
        [DomainName] => example.com
        [AuthCode] => Xy9#mK2$pL5@vN8
        [LockStatus] => true
        [PrivacyProtectionStatus] => false
        [IsChildNameServer] => false
        [Contacts] => Array
        (
            [Billing] => Array
            (
                [ID] => 987654
            )
            [Technical] => Array
            (
                [ID] => 987654
            )
            [Administrative] => Array
            (
                [ID] => 987654
            )
            [Registrant] => Array
            (
                [ID] => 987654
            )
        )
        [Dates] => Array
        (
            [Start] => 2024-03-15T10:00:00+03:00
            [Expiration] => 2025-03-15T10:00:00+03:00
            [RemainingDays] => 365
        )
        [NameServers] => Array
        (
            [0] => ns1.example.com
            [1] => ns2.example.com
        )
        [Additional] => Array
        (
            [TRABISDOMAINCATEGORY] => 1
            [TRABISCITIZIENID] => 98765432109
            [TRABISNAMESURNAME] => Jane Smith
            [TRABISCOUNTRYID] => 840
            [TRABISCITYID] => 34
        )
        [ChildNameServers] => Array
        (
                )
          
        )
    )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Renouvellement de Domaine

```php
$dna->Renew('example.com', 1);
```
<details>
<summary>Exemple de Sortie pour le Renouvellement de Domaine</summary>

```php
Array
(
    [result] => OK
    [data] => Array
    (
        [ExpirationDate] => 2025-03-15T10:00:00+03:00
    )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Transfert de Domaine

```php
$dna->Transfer('example.com', 'Xy9#mK2$', 3);
```

<details>
<summary>Exemple de Sortie pour le Transfert de Domaine</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Suppression de Domaine

```php
$dna->DeleteDomain('example.com');
```

<details>
<summary>Exemple de Sortie pour la Suppression de Domaine</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Informations de Domaine

```php
$dna->GetDetails('example.com');
```

<details>
<summary>Exemple de Sortie pour les Informations de Domaine</summary>

```php
Array
(
    [result] => OK
    [data] => Array
    (
        [ID] => 123456
        [Status] => clientTransferProhibited
        [DomainName] => example.com
        [AuthCode] => Xy9#mK2$pL5@vN8
        [LockStatus] => true
        [PrivacyProtectionStatus] => false
        [IsChildNameServer] => false
        [Contacts] => Array
        (
            [Billing] => Array
            (
                [ID] => 987654
            )
            [Technical] => Array
            (
                [ID] => 987654
            )
            [Administrative] => Array
            (
                [ID] => 987654
            )
            [Registrant] => Array
            (
                [ID] => 987654
            )
        )
        [Dates] => Array
        (
            [Start] => 2024-03-15T10:00:00+03:00
            [Expiration] => 2025-03-15T10:00:00+03:00
            [RemainingDays] => 365
        )
        [NameServers] => Array
        (
            [0] => ns1.example.com
            [1] => ns2.example.com
        )
        [Additional] => Array
        (
            [TRABISDOMAINCATEGORY] => 1
            [TRABISCITIZIENID] => 98765432109
            [TRABISNAMESURNAME] => Jane Smith
            [TRABISCOUNTRYID] => 840
            [TRABISCITYID] => 34
        )
        [ChildNameServers] => Array
        (
                )
          
        )
    )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Informations des Serveurs de Noms

```php
$dna->GetNameServer('example.com');
```

<details>
<summary>Exemple de Sortie pour les Informations des Serveurs de Noms</summary>

```php
Array
(
    [result] => OK
    [data] => Array
    (
        [0] => ns1.example.com
        [1] => ns2.example.com
    )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Modifier les Serveurs de Noms

```php
$dna->ModifyNameServer('example.com', ["ns1.example.com", "ns2.example.com"]);
```

<details>
<summary>Exemple de Sortie pour Modifier les Serveurs de Noms</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Verrouillage de Domaine

```php
$lock = $dna->EnableTheftProtectionLock('example.com');
```

<details>
<summary>Exemple de Sortie pour le Verrouillage de Domaine</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Déverrouillage de Domaine

```php
$unlock = $dna->DisableTheftProtectionLock('example.com');
```

<details>
<summary>Exemple de Sortie pour le Déverrouillage de Domaine</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Ajouter un Serveur de Noms Enfant

```php
$dna->AddChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>Exemple de Sortie pour Ajouter un Serveur de Noms Enfant</summary>

```php
Array
(
    [data] => Array
        (
            [NameServer] => ns1.example.com
            [IPAdresses] => Array
                (
                    [0] => 1.2.3.4
                )
        )
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Supprimer un Serveur de Noms Enfant

```php
$dna->DeleteChildNameServer('example.com', 'ns1.example.com');
```

<details>
<summary>Exemple de Sortie pour Supprimer un Serveur de Noms Enfant</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Modifier un Serveur de Noms Enfant

```php
$dna->ModifyChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>Exemple de Sortie pour Modifier un Serveur de Noms Enfant</summary>

```php
Array
(
    [data] => Array
        (
            [NameServer] => ns1.example.com
            [IPAdresses] => Array
                (
                    [0] => 1.2.3.4
                )
        )
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Modifier la Protection de la Vie Privée

```php
$lock = $dna->ModifyPrivacyProtectionStatus('example.com', true, 'commentaire optionnel du propriétaire');
```

<details>
<summary>Exemple de Sortie pour Modifier la Protection de la Vie Privée</summary>

```php
Array
(
    [result] => OK
    [data] => Array
        (
            [PrivacyProtectionStatus] => true
        )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Sauvegarder le Contact de Domaine

```php
$contact = [
    "FirstName"        => 'Bunyamin',
    "LastName"         => 'Mutlu',
    "Company"          => '',
    "EMail"            => 'bun.mutlu@gmail.com',
    "AddressLine1"     => 'adresse 1 adresse 1 adresse 1 ',
    "AddressLine2"     => 'test test',
    "AddressLine3"     => '',
    "City"             => 'Kocaeli',
    "Country"          => 'TR',
    "Fax"              => '2626060026',
    "FaxCountryCode"   => '90',
    "Phone"            => '5555555555',
    "PhoneCountryCode" => 90,
    "Type"             => 'Contact',
    "ZipCode"          => '41829',
    "State"            => 'GEBZE'
];

$dna->SaveContacts('example.com','ns1','1.2.3.4');
```

<details>
<summary>Exemple de Sortie pour Sauvegarder le Contact de Domaine</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Obtenir les Détails du Revendeur

```php
$dna->GetResellerDetails();
```

<details>
<summary>Exemple de Sortie pour Obtenir les Détails du Revendeur</summary>

```php
Array
(
    [result] => OK
    [id] => 12345
    [active] => 1
    [name] => TEST ACCOUNT 1
    [balance] => 0.0000
    [currency] => USD
    [symbol] => $
    [balances] => Array
        (
            [0] => Array
                (
                    [balance] => 0.0000
                    [currency] => USD
                    [symbol] => $
                )
            [1] => Array
                (
                    [balance] => 0.0000
                    [currency] => TL
                    [symbol] => TL
                )
        )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

## Codes de Retour et d'Erreur avec Descriptions

| Code | Description | Détail |
|------|-------------|--------|
| 1000 | Commande complétée avec succès | Opération réussie. |
| 1001 | Commande complétée avec succès ; action en attente | Opération réussie. Cependant, l'opération est actuellement en file d'attente pour completion. |
| 2003 | Paramètre requis manquant | Erreur de paramètre manquant. Par exemple : aucune entrée de téléphone dans les informations de contact. |
| 2105 | L'objet n'est pas éligible pour le renouvellement | Le statut du domaine n'est pas adapté pour le renouvellement, verrouillé pour les opérations de mise à jour. Le statut ne doit pas être "clientupdateprohibited". Peut être dû à d'autres conditions de statut. |
| 2200 | Erreur d'authentification | Erreur d'autorisation, code de sécurité incorrect ou domaine enregistré avec un autre registraire. |
| 2302 | L'objet existe | Le nom de domaine ou les informations de serveur de noms existent déjà dans la base de données. Ne peut pas être enregistré. |
| 2303 | L'objet n'existe pas | Le nom de domaine ou les informations de serveur de noms n'existent pas dans la base de données. Nouvel enregistrement requis. |
| 2304 | Le statut de l'objet interdit l'opération | Le statut du domaine n'est pas adapté pour les mises à jour, verrouillé pour les opérations de mise à jour. Le statut ne doit pas être "clientupdateprohibited". Peut être dû à d'autres conditions de statut. |

| CODE | DÉTAIL |
|------|--------|
| 101 | Erreur système détaillée pour ({0})! |
| 102 | Erreurs multiples détaillées pour ({0})! |
| 103 | Erreurs inconnues détaillées pour ({0})! |
| 200 | Commande API introuvable ({0})! |
| 210 | Service API introuvable ({0})! |
| 211 | Fournisseur de service API non défini! |
| 300 | Revendeur introuvable! |
| 301 | Votre adresse IP actuelle n'est pas autorisée à accéder. Veuillez vous assurer que vous vous connectez depuis une adresse IP autorisée et réessayez |
| 310 | TLD non supporté! |
| 320 | API introuvable! |
| 321 | Devise non supportée! |
| 330 | Paramètre(s) requis non défini(s) ({0}). |
| – | Assurez-vous d'envoyer tous les objets de contact complets |
| 340 | Définition de prix introuvable ({0}[{1}]-{2}{3}). |
| 350 | Solde de revendeur insuffisant. (Id Revendeur : {0} - Solde Actuel : {1} {2}). |
| 350 | La devise comptable ne correspond pas ou le solde est insuffisant. |
| 360 | Requête API invalide pour le champ ({0}). |
| 360 | Quota API dépassé! |
| 361 | Erreur de limitation! |
| 362 | Le domaine premium n'est pas disponible pour l'enregistrement pour le moment. |
| 363 | Opération annulée car le domaine est en période de renouvellement automatique |
| 364 | Ce domaine est actuellement indisponible pour une transaction en raison d'un problème avec le registre |

| CODE | DÉTAIL |
|------|--------|
| 400 | Contact invalide ({0}). |
| 401 | Les informations de contact ne peuvent pas être synchronisées. |
| 402 | Aucun accès aux informations de contact depuis le registre. |
| 403 | LE SYSTÈME A DES INFORMATIONS MANQUANTES. ENTREZ VOS INFORMATIONS PAR DÉFAUT OU CONTACTEZ L'ÉQUIPE DE SUPPORT. |
| 404 | LE CONTACT DE DOMAINE NE PEUT PAS ÊTRE MIS À JOUR. PERMISSION DU REGISTRE. |
| 410 | Contact introuvable. |
| 410 | Contact introuvable ({0}). |
| 420 | Commande Api invalide pour le contact {0}. |
| 430 | API de contact introuvable. |
| 440 | Le contact n'est pas synchronisé. |
| 450 | Trop de contacts de domaine.. ! |
| 451 | Échec de la poursuite de la mise à jour du contact. |

| CODE | DÉTAIL |
|------|--------|
| 500 | ID de domaine invalide. |
| 500 | ID de domaine invalide ({0}). |
| 501 | Le domaine n'a pas pu être synchronisé({0}) |
| 502 | Transfert interne échoué |
| 503 | L'enregistrement de domaine n'est pas disponible. |
| 504 | Les informations de domaine ne correspondent pas .. Avant :{0} |
| 505 | Entrez l'adresse IP. |
| 506 | Le transfert de domaine a été initié mais les informations de contact n'ont pas pu être lues .. |
| 507 | Erreur d'autorisation. |
| 510 | Domaine introuvable. |
| 511 | Les domaines expirés ne peuvent pas être trouvés. |
| 512 | Le domaine n'est pas renouvelable. |
| 513 | Le domaine n'est pas dans un état modifiable. Il doit être actif pour être mis à jour |
| 514 | Période de rachat attendue. |
| 520 | Commande Api invalide pour le domaine "{0}". |
| 530 | Période de domaine invalide. La période doit être de {0} à {1} ans. La période demandée est de {2} ans. |
| 540 | Le domaine ne peut pas être étendu au-delà de {0} ans à partir de la date actuelle. |
| 550 | Nom de domaine invalide. Le domaine doit avoir une longueur de {0} à {1} caractères. Le nom de domaine demandé fait {2} caractères. |
| 560 | Nombre de serveurs de noms invalide. Le domaine doit avoir {0} à {1} serveurs de noms. Le nombre de serveurs de noms demandé est {2}. |
| 561 | Aucune information de serveur de noms trouvée dans la requête entrante |
| 570 | Idn non supporté pour le tld "{0}". |
| 571 | Période invalide. |
| 572 | Commande invalide. |
| 573 | Noms de domaine introuvables. |
| 574 | Noms TLD introuvables. |
| 575 | Le domaine n'est pas dans un état modifiable. Il doit être actif pour que les serveurs de noms soient mis à jour |
| 576 | Le domaine peut être renouvelé dans le dernier mois avant la date d'expiration |
| 580 | Transfert non supporté pour le tld "{0}". |
| 581 | Serveur de noms enfant introuvable |
| 582 | Transfert initié par un autre revendeur. |
| 583 | Transfert non initialisé. Veuillez contacter l'équipe de support. |
| 584 | Le statut de l'objet interdit l'opération |
| 590 | Le code d'autorisation est requis pour ce transfert. |
| 591 | Le code d'autorisation n'est pas valide. |
| 592 | Un verrou de transfert existe sur le domaine. |
| 593 | Le domaine ne peut pas être transféré, les informations de statut et le verrou de transfert doivent respecter les critères requis. (Informations de statut: #ok) |
| 594 | L'adresse du serveur de noms de domaine n'a pas pu être résolue ({0}) |
| 595 | Les informations de contact ne peuvent pas être lues (whois.registrar.tld) Veuillez vous assurer que le statut de protection de la vie privée est ouvert |
| 596 | Les informations de contact n'ont pas pu être vérifiées |
| 597 | Tld introuvable |
| 598 | Erreur inconnue survenue |
| 599 | Redirection de domaine introuvable |
</rewritten_file> 