<?php

/**
 * Classe ScoreboardDAO
 * 
 * Sert pour gérer la base de données
 */
class ScoreboardDAO
{
    /**
     * Crée la base de données
     */
    public function __construct()
    {
        $db = new SQLite3("database.db");
        $db->exec("create table if not exists scoreboard (username text, score integer)");
        // TODO: gérer erreur
    }

    /**
     * Insère un joueur et son score dans la base de données.
     *
     * @param Player $player Le joueur à insérer.
     * @param int $score Le score à enregistrer.
     */
    /* @ requires $player != null;
         ensures (\old($player) == $player);
    @ */
    public function insert(Player $player, int $score)
    {
        $username = $player->getUsername();

        $db = new SQLite3("database.db");
        $stmt = $db->prepare("DELETE FROM scoreboard WHERE username = ?");
        $stmt->bindParam(1, $username, SQLITE3_TEXT);
        $stmt->execute();


        $stmt = $db->prepare("INSERT INTO scoreboard (username, score) VALUES (?, ?)");
        $stmt->bindParam(1, $username, SQLITE3_TEXT);
        $stmt->bindParam(2, $score, SQLITE3_INTEGER);
        $stmt->execute();
    }

    /**
     * Récupère les trois meilleurs scores de la base de données.
     *
     * @return array Un tableau associatif contenant les trois meilleurs scores.
     */
    /* @ pure @ */
    public function findTopThree(): array
    {
        $db = new SQLite3("database.db");
        $stmt = $db->prepare("SELECT username, score FROM scoreboard ORDER BY score ASC LIMIT 3");
        $res = $stmt->execute();
        $resu = [];
        $i = 0;
        while ($arr = $res->fetchArray(SQLITE3_ASSOC)) {
            $resu[$i] = ["rank" => $i, "username" => $arr["username"], "sore" => $arr["score"]];
            $i += 1;
        }
        return $resu;
    }

    /**
     * Récupère tous les scores de la base de données.
     *
     * @return array Un tableau associatif contenant tous les scores.
     */
    /* @ pure @ */
    public function findAll(): array
    {
        $db = new SQLite3("database.db");
        $stmt = $db->prepare("SELECT username, score FROM scoreboard ORDER BY score ASC");
        $res = $stmt->execute();
        $resu = [];
        $i = 0;
        while ($arr = $res->fetchArray(SQLITE3_ASSOC)) {
            $resu[$i] = ["rank" => $i, "username" => $arr["username"], "score" => $arr["score"]];
            $i += 1;
        }
        return $resu;
    }
}
