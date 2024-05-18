<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Import extends Model
{
    public function stock($devis,$travaux)
    {
        $message = [];
        $ligne = 0;

        DB::table('import_devis')->truncate();
        DB::table('import_maison_travaux')->truncate();

        for ($i = 1; $i < count($devis); $i++) {
            $row = $devis[$i];

            try {
                $ligne++;
                $rules = [
                    '0' => 'required', // numseance
                    '1' => 'required', // film
                    '2' => 'required', // categorie
                    '3' => 'required', // salle
                    '4' => 'required', // date
                    '5' => 'required', // date
                    '6' => 'required', // date
                    '7' => 'required', // date

                ];

                $customMessages = [
                    '0.required' => 'Le champ client est obligatoire.',
                    '1.required' => 'Le champ ref_devis est obligatoire.',
                    '2.required' => 'Le champ type_maison est obligatoire.',
                    '3.required' => 'Le champ finition est obligatoire.',
                    '4.required' => 'Le champ taux_finition est obligatoire.',
                    '5.required' => 'Le champ date_devis est obligatoire.',
                    '6.required' => 'Le champ date_debut est obligatoire.',
                    '7.required' => 'Le champ lieu est obligatoire.',
                ];

                // Valider les données de la ligne actuelle
                $validator = Validator::make($row, $rules, $customMessages);
                if ($validator->fails()) {
                    $errors = $validator->errors()->all();
                    foreach ($errors as $error) {
                        throw new \Exception('Ligne devis : ' . $ligne . ' : ' . $error . '.');
                    }
                }

                // Insertion des données dans la table 'import'
                DB::table('import_devis')->insert([
                    'client' => $row[0],
                    'ref_devis' => $row[1],
                    'type_maison' => $row[2],
                    'finition' => $row[3],
                    'taux_finition' => str_replace('%','',str_replace(',', '.', $row[4])),
                    'date_devis' => $row[5],
                    'date_debut' => $row[6],
                    'lieu' => $row[7],
                ]);
            } catch (\Exception $e) {
                // En cas d'erreur, ajouter un message à la liste des messages d'erreur
                $message[] = $e->getMessage();
            }
    }

        for ($i = 1; $i < count($travaux); $i++) {
            $row = $travaux[$i];

            try {
                $ligne++;
                $rules = [
                    '0' => 'required', // numseance
                    '1' => 'required', // film
                    '2' => 'required', // categorie
                    '3' => 'required', // salle
                    '4' => 'required', // date
                    '5' => 'required', // date
                    '6' => 'required', // date
                    '7' => 'required', // date
                    '8' => 'required', // date
                ];

                // Définir les messages d'erreur personnalisés pour chaque champ
                $customMessages = [
                    '0.required' => 'Le champ type_maison est obligatoire.',
                    '1.required' => 'Le champ description est obligatoire.',
                    '2.required' => 'Le champ surface est obligatoire.',
                    '3.required' => 'Le champ code_travaux est obligatoire.',
                    '4.required' => 'Le champ type_travaux est obligatoire.',
                    '5.required' => 'Le champ unite est obligatoire.',
                    '6.required' => 'Le champ prix_unitaire est obligatoire.',
                    '7.required' => 'Le champ quantite est obligatoire.',
                    '8.required' => 'Le champ duree_travaux est obligatoire.',
                ];

                // Valider les données de la ligne actuelle
                $validator = Validator::make($row, $rules, $customMessages);
                if ($validator->fails()) {
                    $errors = $validator->errors()->all();
                    foreach ($errors as $error) {
                        throw new \Exception('Ligne maison travaux: ' . $ligne . ' : ' . $error . '.');
                    }
                }
                // Insertion des données dans la table 'import'
                DB::table('import_maison_travaux')->insert([
                    'type_maison' => $row[0],
                    'description' => $row[1],
                    'surface' => $row[2],
                    'code_travaux' => $row[3],
                    'type_travaux' => $row[4],
                    'unite' => $row[5],
                    'prix_unitaire' => str_replace(',', '.', $row[6]),
                    'quantite' => str_replace(',', '.', $row[7]),
                    'duree_travaux' => $row[8]
                ]);
            } catch (\Exception $e) {
                // En cas d'erreur, ajouter un message à la liste des messages d'erreur
                $message[] = $e->getMessage();
            }
        }

            try {
                DB::insert(/** @lang text */ 'insert into client (contact) select client from import_devis group by client');
            } catch (\Exception $e) {
                $message[] = " Erreur lors de l'insertion dans la table 'client' : " . $e->getMessage();
            }
            try {
                DB::insert(/** @lang text */ 'insert into maison (nom,description,durre,surface) select type_maison,description,duree_travaux,surface from import_maison_travaux group by type_maison,description,duree_travaux,surface');
            } catch (\Exception $e) {
                $message[] = " Erreur lors de l'insertion dans la table 'maison' : " . $e->getMessage();
            }

            try {
                DB::insert(/** @lang text */ 'insert into finition (nom,pourcentage) select finition,taux_finition from import_devis group by finition,taux_finition');
            } catch (\Exception $e) {
                $message[] = " Erreur lors de l'insertion dans la table 'finition' : " . $e->getMessage();
            }
            try {
                DB::insert(/** @lang text */ 'insert into devisclient (reference, idclient, idmaison, idfinition,datedebut,dateinsertion,lieu)
                            select i.ref_devis,c.idclient,m.idmaison,f.idfinition,i.date_debut,i.date_devis,i.lieu
                            from import_devis i
                            join client c on c.contact = i.client
                            join finition f on f.nom = i.finition
                            join maison m on m.nom = i.type_maison

                            ');
            } catch (\Exception $e) {
                $message[] = " Erreur lors de l'insertion dans la table 'devisclient' : " . $e->getMessage();
            }
            try {
                DB::insert(/** @lang text */ 'insert into travaux (code,designation,unite,prixunitaire) select code_travaux,type_travaux,unite,prix_unitaire from import_maison_travaux group by code_travaux,type_travaux,unite,prix_unitaire');
            } catch (\Exception $e) {
                $message[] = " Erreur lors de l'insertion dans la table 'travaux' : " . $e->getMessage();
            }
            try {
                DB::insert(/** @lang text */ 'insert into travauxmaison (idmaison, idtravaux,quantite)
                                select m.idmaison,t.idtravaux,i.quantite
                                from import_maison_travaux i
                                join travaux t on t.code = i.code_travaux
                                join maison m on m.nom = i.type_maison
                                ');
            } catch (\Exception $e) {
                $message[] = " Erreur lors de l'insertion dans la table 'travauxmaison' : " . $e->getMessage();
            }
            try {
                DB::insert(/** @lang text */ 'insert into detaildevis (reference, idtravaux,prixunitaire,quantite)
                                    select id.ref_devis,t.idtravaux,i.prix_unitaire,i.quantite
                                    from import_maison_travaux i
                                    join travaux t on t.code = i.code_travaux
                                    join maison d on d.nom = i.type_maison
                                    join import_devis id on id.type_maison = i.type_maison
                                    join devisclient dv on dv.reference = id.ref_devis
                                    ');
            } catch (\Exception $e) {
                $message[] = " Erreur lors de l'insertion dans la table 'detaildevis' : " . $e->getMessage();
            }

        try {
            DB::insert(/** @lang text */ 'insert into detailfinition (reference, idfinition,pourcentage)
                                    select i.ref_devis,f.idfinition,i.taux_finition
                                    from import_devis i
                                    join finition f on f.nom = i.finition
                                    join devisclient d on d.reference = i.ref_devis
                                    ');
        } catch (\Exception $e) {
            $message[] = " Erreur lors de l'insertion dans la table 'seance' : " . $e->getMessage();
        }


        return $message;
    }

    public function stockPaiment($data){
        $message = [];
        $ligne = 0;

        for ($i = 1; $i < count($data); $i++) {
            $row = $data[$i]; // Récupérer la ligne de données

            try {
                $ligne++;
                $rules = [
                    '0' => 'required', // numseance
                    '1' => 'required', // film
                    '2' => 'required', // categorie
                    '3' => 'required', // salle
                ];

                // Définir les messages d'erreur personnalisés pour chaque champ
                $customMessages = [
                    '0.required' => 'Le champ numseance est obligatoire.',
                    '1.required' => 'Le champ film est obligatoire.',
                    '2.required' => 'Le champ categorie est obligatoire.',
                    '3.required' => 'Le champ salle est obligatoire.',
                ];

                // Valider les données de la ligne actuelle
                $validator = Validator::make($row, $rules, $customMessages);
                if ($validator->fails()) {
                    $errors = $validator->errors()->all();
                    foreach ($errors as $error) {
                        throw new \Exception('Ligne : ' . $ligne . ' : ' . $error . '.');
                    }
                }
                // Insertion des données dans la table 'import'
                DB::table('paiment')->insert([
                    'ref_devis' => $row[0],
                    'reference' => $row[1],
                    'datepaiment' => $row[2],
                    'montant' => $row[3],
                ]);
            } catch (\Exception $e) {
                // En cas d'erreur, ajouter un message à la liste des messages d'erreur
                $message[] = $e->getMessage();
            }
        }
        return $message;
    }
}
