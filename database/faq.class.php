<?php
declare(strict_types = 1);

class FAQ {
    public int $id;
    public string $question;
    public string $answer;

    public function __construct(int $id, string $question, string $answer) {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
    }

    function save($db) {
        $stmt = $db->prepare('
            UPDATE faq SET question = ?, answer = ?
            WHERE faqId = ?
        ');
        $stmt->execute(array($this->question, $this->answer, $this->id));
    }

    function question() : string {
        return $this->question;
    }

    function answer() : string {
        return $this->answer;
    }

    static function getFaqs(PDO $db) {
        $stmt = $db->prepare('
            SELECT faqId, question, answer
            FROM faq
        ');
        $stmt->execute();
        $faqs = [];
        while ($faq = $stmt->fetch()) {
            $faqs[] = new FAQ(
                $faq['faqId'],
                $faq['question'],
                $faq['answer']
            );
        }
        return $faqs;
    }

    static function createFaq(PDO $db, string $question, string $answer) {
        $stmt = $db->prepare('
            INSERT INTO faq (question, answer)
            VALUES (?, ?)
        ');
        $stmt->execute(array($question, $answer));
        return $db->lastInsertId();
    }
}


?>