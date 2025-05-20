<?php
session_start();
require_once __DIR__ . '/../assets/database.php';

// 1) Require login
if (empty($_SESSION['memberID'])) {
    header('Location: ../login/loginForm.html');
    exit;
}

$user = $_SESSION['memberName'] ?? null;

// 2) Get question ID
$qid = intval($_GET['id'] ?? 0);
if (!$qid) {
    header('Location: ../pages/forum.php');
    exit;
}

// 3) Fetch question
$qStmt = sqlsrv_query($connect, "
  SELECT
    q.questionID,
    q.title,
    q.body,
    CONVERT(varchar(16), q.postedAt,120) AS postedAt,
    c.name AS category,
    m.name AS author
  FROM questions q
  JOIN categories c ON q.categoryID=c.categoryID
  JOIN members m ON q.memberID=m.memberID
  WHERE q.questionID=?
", [$qid]);
$question = sqlsrv_fetch_array($qStmt, SQLSRV_FETCH_ASSOC);

// 4) Fetch replies
$rStmt = sqlsrv_query($connect, "
  SELECT
    r.body,
    CONVERT(varchar(16), r.postedAt,120) AS postedAt,
    m.name AS author
  FROM replies r
  JOIN members m ON r.memberID=m.memberID
  WHERE r.questionID=?
  ORDER BY r.postedAt ASC
", [$qid]);
$replies = [];
while ($r = sqlsrv_fetch_array($rStmt, SQLSRV_FETCH_ASSOC)) {
    $replies[] = $r;
}

// 5) Emit JS and include template
?>
<!DOCTYPE html>
<script>
  const question = <?= json_encode($question) ?>;
  const replies  = <?= json_encode($replies) ?>;
  const memberID = <?= json_encode($_SESSION['memberID']) ?>;
</script>
<?php include __DIR__ . '/../thread/threadForm.html'; ?>
