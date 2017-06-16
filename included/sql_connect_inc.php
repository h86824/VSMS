<?php
class AccessBD{
	
	private $m_db_host = "140.127.74.226:3306";
	private $m_db_name = "410477024";
	private $m_user_name = "410477024";
	private $m_user_password = "2h0cl";//2h0cl
	private $m_db;
	
	function AccessBD(){
	}
	
	function connect(){
		try{
			$m_dsn = "mysql:host=$this->m_db_host;dbname=$this->m_db_name";
			
			$this->m_db = new PDO($m_dsn , $this->m_user_name , $this->m_user_password ,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" , PDO::ATTR_PERSISTENT => true));
			
			$this->m_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return true;
		}catch(Exception $e){
			die("Can't connect with Database");
			return false;
		}
	}
	
	function check_login($account , $password){
		$sql = "SELECT password FROM employee WHERE account = ?";
		$prep = $this->m_db->prepare($sql);
		$prep->execute(array($account));
		
		$row = $prep->fetch(PDO::FETCH_OBJ);
		if($row != null && $row->password == $password)
			return true;
		else
			return false;
	}
	
	function get_authorization($account){
		$sql = "SELECT authorization FROM employee WHERE account = ?";
		$prep = $this->m_db->prepare($sql);
		$prep->execute(array($account));
		
		$row = $prep->fetch(PDO::FETCH_OBJ);
		
		return $row->authorization;
	}
	
	function insert_movie($title , $release_date , $charge_per_download = 0){
		if($title == null || $release_date == null){
			return array(false , "請填寫完整資料");
		}
		
		try{
			$sql = "SELECT COUNT(*) FROM movie WHERE title = ? AND release_date = ?";
			$prep = $this->m_db->prepare($sql);
			$prep->execute(array($title , $release_date));
			
			$count = $prep->fetchColumn();
		}catch (Exception $e){
			return array(false , $e);
		}
		
		if($count > 0)
			return array(false , "已存在這部電影");
		else{
			$sql = "INSERT INTO movie (title , release_date , charge_per_download) VALUES (N? , ? , ?)";
			$prep = $this->m_db->prepare($sql);
			$flag = $prep->execute(array($title , $release_date , $charge_per_download));
		}
		if($flag)
			return array(true , "新增成功");
		else
			return array(false , "新增失敗");
	}
	
	function query_movie($movie_id , $title , $release_from , $release_to , $film_type, $sort_type){
		$sql = "SELECT movie_id , title , release_date , charge_per_download FROM movie WHERE true";
		
		if($movie_id != null)
			$sql = $sql ." && movie_id = :movie_id";
		if($title != null)
			$sql = $sql ." && title LIKE :title";
		if($release_from != null)
			$sql = $sql ." && release_date >= :release_from";
		if($release_to != null)
			$sql = $sql ." ORDER BY :sort_type";
			
		if($sort_type!= null){
			switch($sort_type){
				case "release_date_descending":
					$sql = $sql." ORDER BY release_date DESC";
					break;
				case "release_date_ascending":
					$sql = $sql." ORDER BY release_date ASC";
					break;
			}
		}
		
		$sql = $sql.";";
		
		$prep = $this->m_db->prepare($sql);
		if($movie_id != null)
			$prep->bindValue(":movie_id", $movie_id);
		if($title != null){
			$title = '%' .$title . '%';
			$prep->bindValue(":title", $title);
		}
		if($release_from!= null)$prep->bindValue(":release_from", $release_from);
		if($release_to!= null)$prep->bindValue(":release_to", $release_to);
		
		$flag = $prep->execute();
		
		return $prep;
	}
	
	function query_movie_with_actor($movie_id , $title , $release_from , $release_to , $actor , $film_type, $sort_type){
		$sql = "SELECT movie_id , title , release_date , charge_per_download FROM movie_and_actor WHERE true";
		
		if($movie_id != null)
			$sql = $sql ." && movie_id = :movie_id";
		if($title != null)
			$sql = $sql ." && title LIKE :title";
		if($release_from != null)
			$sql = $sql ." && release_date >= :release_from";
		if($actor!= null)
			$sql = $sql ." && name LIKE :actor";
		
		if($release_to != null)
			$sql = $sql ." ORDER BY :sort_type";
		
		if($sort_type!= null){
			switch($sort_type){
			case "release_date_descending":
				$sql = $sql." ORDER BY release_date DESC";
				break;
			case "release_date_ascending":
				$sql = $sql." ORDER BY release_date ASC";
				break;
			}
		}
				
		$sql = $sql.";";
		
		$prep = $this->m_db->prepare($sql);
		if($movie_id != null)
			$prep->bindValue(":movie_id", $movie_id);
		if($title != null){
			$title = '%' .$title . '%';
			$prep->bindValue(":title", $title);
		}
		if($actor != null){
			$actor= '%' .$actor. '%';
			$prep->bindValue(":actor", $actor);
		}
		if($release_from!= null)$prep->bindValue(":release_from", $release_from);
		if($release_to!= null)$prep->bindValue(":release_to", $release_to);
				
		$flag = $prep->execute();
							
		return $prep;
	}
	
	function update_movie($movie_id , $title , $release_date , $charge_per_download){
		$sql = "UPDATE movie SET title=:title , release_date=:release_date , charge_per_download=:charge_per_download WHERE movie_id=:movie_id";
		
		$prep = $this->m_db->prepare($sql);
		$prep->bindValue(":movie_id", $movie_id);
		$prep->bindValue(":title", $title);
		$prep->bindValue(":release_date", $release_date);
		$prep->bindValue(":charge_per_download", $charge_per_download);
		try{
			$prep->execute();
		}catch (Exception $e){
			return $e;
		}
		
		return "修改完成";
	}
	
	function query_actor($actor_id , $actor_name , $actor_birthday){
		$sql = "SELECT actor_id , name , birthday , gender FROM actor WHERE true";
		
		if($actor_id != null)
			$sql = $sql ." && actor_id = :actor_id";
		if($actor_name != null)
			$sql = $sql ." && name LIKE :name";
		if($actor_birthday != null)
			$sql = $sql ." && birthday = :birthday";
		
		$sql = $sql.";";
			
		$prep = $this->m_db->prepare($sql);
		if($actor_id != null)
			$prep->bindParam(":actor_id", $actor_id);
		if($actor_name!= null){
			$actor_name = "%" .$actor_name ."%";
			$prep->bindParam(":name", $actor_name);
		}
		if($actor_birthday!= null)
			$prep->bindParam(":birthday", $actor_birthday);
		
		$prep->execute();
		
		return $prep;
	}
	
	function insert_actor($actor_name , $actor_birthday , $actor_gender){
		if($actor_name == null || $actor_birthday == null || $actor_gender == null)
			return "請填寫完整資料";
		$sql = "SELECT COUNT(*) FROM actor WHERE name=? AND birthday=?";
		
		$prep = $this->m_db->prepare($sql);
		$prep->execute( array($actor_name , $actor_birthday));
		$count = $prep->fetchColumn();
		if($count > 0)
			return "已經存在這個演員";
		
		$sql = "INSERT INTO `actor` (`actor_id`, `name`, `birthday`, `gender`) VALUES (NULL, N?, ?, N?);";
		
		$prep = $this->m_db->prepare($sql);
		try{
			$flag = $prep->execute( array($actor_name , $actor_birthday , $actor_gender));
		}catch(Exception $e){
			return "出了點問題，請稍後再試";
		}
		if($flag)
			return "新增成功";
		else
			return "新增失敗";
	}
	
	function insert_actor_into_movie($movie_id , $actor_id , $role){
		$sql = "INSERT INTO `act` (`movie_id`, `actor_id`, `role`) VALUES (N?, ?, N?);";
		
		$prep = $this->m_db->prepare($sql);
		
		$flag = $prep->execute( array($movie_id , $actor_id , $role));	
	}
	
	function insert_genre_into_movie($movie_id , $genre_name){
		$sql = "INSERT INTO genre (genre_name , movie_id) VALUES(N? , ?)";
		$this->m_db->prepare($sql)->execute(array($genre_name , $movie_id));
	}
	
	function delete_genre_from_movie($movie_id , $genre_name){
		$sql = "DELETE FROM genre WHERE movie_id=? AND genre_name=?";
		$this->m_db->prepare($sql)->execute( array( $movie_id , $genre_name) );
	}
	
	function query_genre_from_movie($movie_id){
		$sql = "SELECT * FROM genre WHERE movie_id=?";
		$prep = $this->m_db->prepare($sql);
		$prep->execute(array($movie_id));
		return $prep;
	}
	
	function get_genres(){
		$sql = "SELECT * FROM genre_type";
		return $this->m_db->query($sql);
	}
	
	function delet_actor_from_movie($movie_id , $actor_id){
		$sql = "DELETE FROM act WHERE movie_id=? AND actor_id=?";
		$prep = $this->m_db->prepare($sql);
		$prep->execute( array($movie_id , $actor_id) );
	}
	
	function insert_director_into_movie($movie_id , $director_id){
		$sql = "INSERT INTO `direct` (`movie_id`, `director_id`) VALUES (?, ?);";
		
		$prep = $this->m_db->prepare($sql);
		
		$flag = $prep->execute( array($movie_id , $director_id));	
	}
	
	function delete_director_from_movie($movie_id , $director_id){
		$sql = "DELETE FROM direct WHERE movie_id=? AND director_id=?";
		$prep = $this->m_db->prepare($sql);
		$prep->execute( array($movie_id , $director_id) );
	}
	
	function query_act($movie_id , $actor_id){
		if($movie_id != null && $actor_id == null){
			$sql = "SELECT actor_id, name , role FROM act NATURAL JOIN actor WHERE movie_id = ?";
			$prep = $this->m_db->prepare($sql);
			$prep->execute(array($movie_id));
			
			return $prep;
		}
		else if($movie_id == null && $actor_id != null){
			$sql = "SELECT title FROM act NATURAL JOIN movie WHERE actor_id = ?";
			$prep = $this->m_db->prepare($sql);
			$prep->execute(array($actor_id));
			
			return $prep;
		}
	}
	
	function query_direct($movie_id){
		$sql = "SELECT * FROM movie NATURAL JOIN direct NATURAL JOIN director WHERE movie_id=?";
		$prep = $this->m_db->prepare($sql);
		$prep->execute(array($movie_id));
		return $prep;
	}
	
	function insert_member($name , $birthday , $phone){
		if($name== null || $birthday== null || $phone == null){
			return "請輸入完整資料";
		}
		
		try{
			$sql = "SELECT COUNT(*) FROM member WHERE name = ? AND birthday= ? AND phone=?";
			$prep = $this->m_db->prepare($sql);
			$prep->execute(array($name, $birthday , $phone));
			
			$count = $prep->fetchColumn();
		}catch (Exception $e){
			return array(false , $e);
		}
		
		if($count > 0)
			return array(false , "已存在這個會員資料");
		
		else{
			$sql = "INSERT INTO member (name , birthday , phone) VALUES (N? , ? , ?)";
			$prep = $this->m_db->prepare($sql);
			$flag = $prep->execute(array($name, $birthday, $phone));
		}
		if($flag)
			return array(true , "新增成功");
		else
			return array(false , "新增失敗");
	}
	
	function query_member($member_id , $name , $birthday , $phone){
		$sql = "SELECT * FROM member WHERE true";
		
		if($member_id != null)
			$sql = $sql ." AND member_id = :member_id";
		if($name!= null)
			$sql = $sql ." AND name LIKE :name";
		if($birthday!= null)
			$sql = $sql ." AND birthday =:birthday";
		if($phone!= null)
			$sql = $sql ." AND phone = :phone";
		
		$sql = $sql.";";
		
		$prep = $this->m_db->prepare($sql);
		
		if($member_id!= null)
			$prep->bindParam(":member_id", $member_id);
		if($name!= null){
			$actor_name = "%" .$name ."%";
			$prep->bindParam(":name", $actor_name);
		}
		if($birthday!= null)
			$prep->bindParam(":birthday", $birthday);
		if($phone!= null)
			$prep->bindParam(":phone", $phone);
						
		$prep->execute();
		
		return $prep;
	}
	
	function update_member($member_id , $name , $birthday , $phone){
		$sql = "UPDATE member SET name=:name , birthday=:birthday , phone=:change_phone WHERE member_id=:member_id;";
		
		$prep = $this->m_db->prepare($sql);
		$prep->bindValue(":member_id", $member_id);
		$prep->bindValue(":name", $name);
		$prep->bindValue(":birthday", $birthday);
		$prep->bindValue(":change_phone", $phone);
		$prep->execute();
		
		return $prep->columnCount();
	}
	
	function query_director($director_id , $name , $birthday , $gender){
		$sql = "SELECT * FROM director WHERE true";
		
		if($director_id != null){
			$sql = $sql .' AND director_id = :director';
		}
		
		if($name != null){
			$sql = $sql .' AND name=:name';
		}
		if($birthday != null){
			$sql = $sql .' AND birthday=:birthday';
		}
		
		if($gender != null){
			$sql = $sql .' AND gender=:gender';
		}
		
		$prep = $this->m_db->prepare($sql);
		
		if($director_id != null){
			$prep->bindValue(":director", $director_id);
		}
		
		if($name != null){
			$prep->bindValue(":name", $name);
		}
		
		if($birthday != null){
			$prep->bindValue(":birthday", $birthday);
		}
		
		if($gender != null){
			$prep->bindValue(":gender", $gender);
		}
		
		$prep->execute();
		return $prep;
	}
	
	function insert_director($name , $birthday , $gender){
		if($name == null || $birthday == null || $gender == null){
			return '請輸入完整資料';
		}
		
		$prep = $this->m_db->prepare("SELECT COUNT(*) FROM director WHERE name=? AND birthday=? AND gender=?;");
		$prep->execute( array($name , $birthday , $gender) );
		$count = $prep->fetchColumn();
		if($count > 0)
			return "已有相同資料存在";
		
		$prep = $this->m_db->prepare("INSERT INTO director ( director_id , name , birthday , gender ) VALUES ( null , N? , ? , ?)");
		$flag = $prep->execute( array($name , $birthday , $gender) );
		
		if($flag)
			return '新增成功!';
		else
			return '新增失敗';
	}
	
	function update_director($director_id , $name , $birthday, $gender){
		$sql = "UPDATE director SET name=:name , birthday=:birthday , gender=:gender WHERE director_id=:director_id;";
		
		$prep = $this->m_db->prepare($sql);
		$prep->bindValue(":director_id", $director_id);
		$prep->bindValue(":name", $name);
		$prep->bindValue(":birthday", $birthday);
		$prep->bindValue(":gender", $gender);
		$prep->execute();
		
		return $prep->rowCount();
	}
	
	function insert_participate($director_id){
		$sql = "SELECT COUNT(*) FROM participate WHERE directir_id = ?";
		
		$prep = $this->m_db->prepare($sql);
		$prep->execute( array($director_id) );
		$count = $prep->fetchColumn();
		
		if($count == 0){
			
		}
		
	}
	
	function query_user_download_record($member_name){
		$sql = "SELECT title , release_date , date FROM downloads_view WHERE member_id=?";
		
		$prep = $this->m_db->prepare($sql);
		
		$prep->execute( array($member_name));
		
		return $prep;
	}
	
	function query_movie_download($member_name , $date_from , $date_to){
		$sql = "SELECT title , release_date , COUNT(*) as count FROM downloads_view WHERE true";
		
		if($member_name!= null){
			$sql = $sql ." AND name=:name";
		}
		if($date_from != null){
			$sql = $sql ." AND :date_from <= date";
		}
		if($date_to != null){
			$sql = $sql ." AND :date_to >= date";
		}
		
		$sql = $sql ." GROUP BY movie_id ";
		
		$prep = $this->m_db->prepare($sql);
		
		if($member_name!= null){
			$prep->bindValue(":name", $member_name);
		}
		if($date_from != null){
			$prep->bindValue(":date", $date_from);
		}
		if($date_to != null){
			$prep->bindValue(":date", $date_from);
		}
		
		$prep->execute();
		
		return $prep;
	}
	
	function query_favorite_actress($member_id){
		$sql = 'SELECT name , birthday
			FROM actor NATURAL JOIN(
			SELECT actor.actor_id , name , COUNT(*) AS number
			FROM act INNER JOIN actor 
			ON act.actor_id = actor.actor_id AND gender = "female" 
			WHERE movie_id in
			(SELECT movie_id
			FROM member NATURAL JOIN download NATURAL JOIN movie
			WHERE member_id = ?)
			GROUP BY actor_id) AS T
			GROUP BY actor_id
			HAVING MAX(number)';
		
	}
}
?>