<?php
    declare(strict_types = 1);

    class Department {
        public int $id;
        public string $name;

        public function __construct(int $id, string $name) {
            $this->id = $id;
            $this->name = $name;
        }

        static function createDepartment(PDO $db, string $name) {
            $stmt = $db->prepare('
                INSERT INTO department (name) VALUES (?)
            ');
            $stmt->execute(array($name));
        }

        static function getDepartment(PDO $db, int $id) {
            $stmt = $db->prepare('
                SELECT *
                FROM department
                WHERE departmentId = ?
            ');
            $stmt->execute(array($id));
            $department = $stmt->fetch();

            return new Department(
                $department['departmentId'],
                $department['name']
            );
        }

        static function getAllDepartments(PDO $db) : array {
            $stmt = $db->prepare('
                SELECT *
                FROM department
                ORDER BY name ASC
            ');
            $stmt->execute();
            $departments = [];
            while ($department = $stmt->fetch()) {
                $departments[] = new Department(
                    $department['departmentId'],
                    $department['name']
                );
            }
            return $departments;
        }

        public function getAllAgentsOfDepartment(PDO $db) {
            $stmt = $db->prepare('
                SELECT u.userId, u.username, u.actualName, u.birthDate, u.gender, u.email, u.bio, u.userImage, u.dateJoin, a.departmentId
                FROM user u JOIN agent a
                ON u.userId = a.agentId
                WHERE a.departmentId = ?
            ');
            $stmt->execute(array($this->id));
            $agents = [];
            while($agent = $stmt->fetch()) {
                $agents[] = new User(
                    $agent['userId'],
                    $agent['username'],
                    $agent['actualName'],
                    $agent['birthDate'],
                    $agent['gender'],
                    $agent['email'],
                    $agent['bio'],
                    $agent['userImage'],
                    $agent['dateJoin'],
                    $agent['departmentId']
                );
            }
            return $agents;
        }
    }

?>