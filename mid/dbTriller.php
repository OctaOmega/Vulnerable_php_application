<?php

define("DB", "midterm");                         
define("TB_USERS", DB . ".users");              
define("TB_USERS_ID", TB_USERS . ".id");       
define("TB_USERS_NAME", TB_USERS . ".name");
define("TB_USERS_PASS", TB_USERS . ".pass");
define("TB_USERS_SALT", TB_USERS . ".salt");
define("TB_POSTS", DB . ".posts");              
define("TB_POSTS_ID", TB_POSTS . ".id");             
define("TB_POSTS_USER", TB_POSTS . ".user");       
define("TB_FOLLS", DB . ".followers");          

class dbTriller
{
	private $host = "127.0.0.1";
    private $user = "<dbuser>";             
    private $pass = "<dbpass>";            
    private $database = DB;
    
    private $connection;
    private $connected = FALSE;
     
	public function __construct()
	{
        date_default_timezone_set("America/Toronto");

        $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->database);

        if( !$this->connection->connect_error ) $this->connected = TRUE;
    }
    function __destruct()
    {
    	if($this->connected) $this->connection->close();
    }
    public function connected()
    {
    	return $this->connected;
    }
    /**
     * A helper function to retreive the id of a user name [SELECT id...]
     *
     * @params string $name name of Triller user
     *
     * @param string $name
     *
     * @return int user id, -1 if error
     */
    private function getUserId($name)
    {
        $query = "SELECT id FROM " . TB_USERS . " WHERE name = '$name'";

    	if ($result = $this->connection->query($query)) 
    	{
    		$row = $result->fetch_row();
            $result->close();
    		return $row[0];
    	}

    	return -1;
    }
    /**
     * A method that returns the number of followers of a Triller user [SELECT *]
     *
     * @params string $name name of Triller user
     *
     * @param string $name
     *
     * @return int number of followers, -1 if error
     */
    public function getNoFollowers($name)
    {
    	$id = $this->getUserId($name);

        $query = "SELECT * FROM " . TB_FOLLS . " WHERE follower = '$id'";

    	if ($result = $this->connection->query($query)) 
    	{
            $count = $result->num_rows; 
            $result->close();
    		return $count; 
    	}

    	return -1;
    }
    /**
     * A method that returns the number of users a Triller user follows [SELECT *]
     *
     * @params string $name name of Triller user
     *
     * @param string $name
     *
     * @return int number of users followed, -1 if error
     */
    public function getNoFollowing($name)
    {
    	$id = $this->getUserId($name);

        $query = "SELECT * FROM " . TB_FOLLS . " WHERE user = '$id'";

    	if ($result = $this->connection->query($query)) 
    	{
            $count = $result->num_rows; 
            $result->close();
            return $count; 
    	}

    	return -1;
    }
     /**
     * A method to insert a Trill in the posts table [INSERT INTO]
     *
     * @params string $name name of Triller user, string $post the trill
     *
     * @param string $name
     * @param string $post [LIMIT TO 280 IN QUERY]
     *
     * @return bool(true) if success, 0 if fail
     */
    public function postTrill($name, $post)
    {
        $id = $this->getUserId($name);
        $now = date('Y-m-d H:i:s');

        $query = "INSERT INTO " . TB_POSTS . " (user, post, pdate) VALUES ('$id', (SUBSTRING('$post', 1, 280)), '$now')";

        if($result = $this->connection->query($query)) 
        {
           return $result;
        }

        return 0;
    }
	
    public function checkuser($first)
    {
        $name = $first;
		
		$query = "SELECT " . TB_USERS_ID . " FROM " . TB_USERS . " WHERE " . TB_USERS_NAME . " = '$name'";
		
		if($result = $this->connection->query($query))
		{	
			$res[] = $result->fetch_assoc();
			return $res[0];
			
		} 
		
		return 0;
    }	


    public function useradd($first, $last, $gender, $email, $pass)
    {
        $name = $first;	
		$pass1 = md5($pass);
		
		$query = "INSERT INTO " . TB_USERS . " (name, fname, lname, gender, email, pass) VALUES ('$name', '$first', '$last', '$gender', '$email', '$pass1') ";

			if($result = $this->connection->query($query)) 
			{
			   return $result;
			}
		
        return 0;
    }
    
    public function searchPosts($userInput)
    
    {
        $res = array();


       $query = "SELECT * FROM midterm.posts WHERE post LIKE '%" . $userInput . "%'";
        
        $result = $this->connection->query($query);

    	if($result && $result->num_rows > 0) 
    	{
    		for($i = 0; $i < $result->num_rows; $i++) $res[] = $result->fetch_assoc();
    	}
        
      return $res;
      

    }

     /**
     * A method to delete a Trill from the posts table [DELETE FROM]
     *
     * @params int $id id of the Trill
     *
     * @param int $id
     *
     * @return bool(true) if success, 0 if fail
     */
    public function removeTrill($id)
    {
        $query = "DELETE FROM " . TB_POSTS . " WHERE id = '$id'";

        if($result = $this->connection->query($query)) 
        {
            return $result;
        }

        return 0;
    }
    /**
     * A method to retrieve all Trills [SELECT...]
     *
     * Cols: posts.id, users.name, posts.post, posts.pdate sorted by posts.pdate descending
     *
     * @return array of Trills or empty array
     */
    public function getUserPosts()
    {
        $res = array();

       //$query =  "SELECT " . TB_POSTS_ID . ", post, pdate, (SELECT name FROM " . TB_USERS . " WHERE " . TB_USERS_ID . " = " . TB_POSTS_USER . ") FROM " . TB_POSTS . " ORDER BY pdate DESC";

       $query =  "SELECT " . TB_POSTS_ID . ", post, pdate, name FROM " . TB_POSTS . "," . TB_USERS . " WHERE " . TB_USERS_ID . " = " . TB_POSTS_USER . " ORDER BY pdate DESC";
        
        $result = $this->connection->query($query);

    	if($result && $result->num_rows > 0) 
    	{
    		for($i = 0; $i < $result->num_rows; $i++) $res[] = $result->fetch_assoc();
    	}

        $result->close();
        return $res;
    }

     function authenticate($no, $user, $pass)
    {
        switch ($no) {
            case 1:
                return $this->authenticate1($user, $pass);   
            default:
                return NULL;
        }
    }

    function authenticate1($user, $pass)
    {   
        $query = "SELECT " . TB_USERS_NAME . "," . TB_USERS_PASS . 
        " FROM " . TB_USERS . 
        " WHERE " . TB_USERS_PASS . " = md5('$pass')"; 
        
        
        //$query = (" SELECT " . TB_USERS_NAME . "," . TB_USERS_PASS . " FROM " . TB_USERS . " WHERE " . TB_USERS_PASS . " = md5('$pass')";
        //if($result = $this->connection->query($this->connection->reak_escape_string($query)))
        
        if($result = $this->connection->query($query))
        {
            $res[] = $result->fetch_assoc();
            $result->close();
            return $res[0];
        }
        return NULL;
    }
}
?>




