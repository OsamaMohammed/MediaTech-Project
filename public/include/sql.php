<?php

class OSASQL{

    private static $db_connection;
    

    public static function connect() {
        if (self::$db_connection == null) {
            try {
                self::$db_connection = new \PDO("sqlite:../database.sqlite");
            } catch (Exception $e) {
                echo($e->getMessage());
                exit('Something weird happened'); //something a user can understand
            }
        }
        self::$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$db_connection;
    }

    /**
     * get top 3 users by thier post numbers
     *
     * @return void
     */
    public static function getTopUsers(){
        $conn = self::connect();
        $stmt = $conn->query("SELECT 
        posts.user_id, users.username, count(posts.id) AS PostNumbers 
        from posts INNER JOIN users ON posts.user_id=users.id
        group by user_id order by PostNumbers desc limit 3;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * get top 3 hashtags used
     *
     * @return void
     */
    public static function getTopHashtags(){
        $conn = self::connect();
        $stmt = $conn->query("SELECT 
        hashtag_names.text, count(hashtags.hashtag_id) AS Used
        from hashtags INNER JOIN hashtag_names ON hashtags.hashtag_id=hashtag_names.id
        group by hashtag_id order by Used desc limit 3;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insert new hash to hash tables
     * return id of new inserted hash
     * @param string $hash
     * @return int
     */
    public static function insertHash($tag){
        $conn = self::connect();
        $sql = "INSERT INTO hashtag_names(text) VALUES (?)";
        $conn->prepare($sql)->execute([$tag]);
        return $conn->lastInsertId();
    }

    /**
     * Insert HashIds for specific post
     *
     * @param array $hashIds
     * @param int $post_id
     * @return int
     */
    public static function insertPostHash($hashIds, $post_id){
        $str = "(?, $post_id)";
        for($i=1;$i<count($hashIds);$i++){
            $str .= ",(?, $post_id) ";
        }
        $conn = OSASQL::connect();
        $sql = "INSERT INTO hashtags(hashtag_id, post_id) VALUES " . $str . ";";
        return $conn->prepare($sql)->execute($hashIds);
    }

    /**
     * Get all hashtag related posts
     *
     * @param string $hashtag
     * @param int $offset
     * @param int $perPage
     * @return array
     */
    public static function getHashtagPosts($hashtag, $offset, $perPage){
        $conn = OSASQL::connect();
        $stmt = $conn->prepare("SELECT 
        posts.id, posts.comments, posts.image, posts.upload_time, users.username, users.full_name FROM
        posts INNER JOIN hashtags ON hashtags.post_id=posts.id
        INNER JOIN users on posts.user_id=users.id
        Where hashtag_id = (SELECT id from hashtag_names where text = ?)
        ORDER BY posts.id DESC LIMIT $offset, $perPage;");
        $stmt->execute([$hashtag]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all hashtag related posts
     *
     * @param string $hashtag
     * @param int $offset
     * @param int $perPage
     * @return array
     */
    public static function getUserPosts($user_id, $offset, $perPage){
        $conn = OSASQL::connect();
        $stmt = $conn->query("SELECT
        posts.id, posts.comments, posts.image, posts.upload_time, users.username, users.full_name
        FROM posts 
        INNER JOIN users ON posts.user_id=users.id
        Where user_id = $user_id ORDER BY posts.id DESC LIMIT $offset, $perPage;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}