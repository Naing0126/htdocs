<?
    // 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)
 $db = new PDO('mysql:host=ja-cdbr-azure-west-a.cloudapp.net:3306;dbname=naingteAwFvNFAtW;charset=utf8', 'b7f51aceb56551', '1eb37f2f');

   // 세션 시작
   session_start();

   $user_id = $_REQUEST['id'];
   $user_pw = $_REQUEST['pw'];

   // 쿼리문 생성
   $sql = "select * from user where user_id='$user_id' and user_pw='$user_pw'";

   // 쿼리 실행 결과를 $result에 저장
   $stmt = $db->query($sql);
   // 반환된 전체 레코드 수 저장.

   $total_record = $stmt->rowCount();

   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "{\"status\":\"OK\",\"num_results\":\"$total_record\",\"results\":[";
   // 반환된 각 레코드별로 JSONArray 형식으로 만들기.
   for ($i=0; $i < $total_record; $i++)
   {

    $row = $results[$i];
      // 가져올 레코드로 위치(포인터) 이동
    echo "{\"uid\":$row[uid],\"user_id\":\"$row[user_id]\",\"user_pw\":\"$row[user_name]\",\"user_name\":\"$row[user_name]\"}";

   // 마지막 레코드 이전엔 ,를 붙인다. 그래야 데이터 구분이 되니깐.
   if($i<$total_record-1){
      echo ",";
   }

   }
   // JSONArray의 마지막 닫기
   echo "]}";
?>