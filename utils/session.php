<?php
    class Session {
        private array $messages;

        public function __construct() {
            session_start();

            $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
            unset($_SESSION['messages']);
        }

        public function isLoggedIn() : bool {
            return isset($_SESSION['id']);
        }

        public function logout() {
            session_destroy();
        }

        public function getId() : ?int {
            return isset($_SESSION['id']) ? (int)$_SESSION['id'] : null;
        }

        public function getUsername() : ?string {
            return isset($_SESSION['username']) ? $_SESSION['username'] : null;
        }

        public function getEmail() : ?string {
            return isset($_SESSION['email']) ? $_SESSION['email'] : null;
        }

        public function getProfilePic() : ?string {
            return isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : null;
        }

        public function setId(int $id) {
            $_SESSION['id'] = $id;
        }

        public function setUsername(string $username) {
            $_SESSION['username'] = $username;
        }

        public function setProfilePic(string $profilePic) {
            $_SESSION['profile_pic'] = $profilePic;
        }

        public function addMessage(string $type, string $text) {
            $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
        }

        public function getMessages() {
            return $this->messages;
        }

        public function setAgent() {
            $_SESSION['agent'] = true;
        }

        public function isAgent() {
            return isset($_SESSION['agent']) ? $_SESSION['agent'] : false;
        }

        public function setAdmin() {
            $_SESSION['admin'] = true;
        }

        public function isAdmin() {
            return isset($_SESSION['admin']) ? $_SESSION['admin'] : false;
        }
    }
?>