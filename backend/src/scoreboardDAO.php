<?php
class ScoreboardDAO
{
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
    public function insert(Player $player, int $score)
    {
        $db = new SQLite3("database.db");
        $stmt = $db->prepare("INSERT INTO scoreboard (username, score) VALUES (?, ?)");
        $stmt->bindParam(1, $player->getUsername(), SQLITE3_TEXT);
        $stmt->bindParam(2, $score, SQLITE3_INTEGER);
        $stmt->execute();
    }

    /**
     * Récupère les trois meilleurs scores de la base de données.
     *
     * @return array Un tableau associatif contenant les trois meilleurs scores.
     */
    public function findTopThree(): array
    {
        $db = new SQLite3("database.db");
        $stmt = $db->prepare("SELECT username, score, (SELECT count(*) FROM scoreboard s2 WHERE s2.username < s.username) + 1 as row FROM scoreboard s ORDER BY score DESC LIMIT 3");
        $res = $stmt->execute();
        $resu = [];
        while ($arr = $res->fetchArray(SQLITE3_ASSOC)) {
            $resu[$arr["row"]] = ["username" => $arr["username"], "score" => $arr["score"]];
        }
        return $resu;
    }

    /**
     * Récupère tous les scores de la base de données.
     *
     * @return array Un tableau associatif contenant tous les scores.
     */
    public function findAll(): array
    {
        $db = new SQLite3("database.db");
        $stmt = $db->prepare("SELECT username, score, (SELECT count(*) FROM scoreboard s2 WHERE s2.username < s.username) + 1 as row FROM scoreboard s ORDER BY score DESC");
        $res = $stmt->execute();
        $resu = [];
        while ($arr = $res->fetchArray(SQLITE3_ASSOC)) {
            $resu[$arr["row"]] = ["username" => $arr["username"], "score" => $arr["score"]];
        }
        return $resu;
    }
}
