<?php
App::uses('AuthComponent', 'Controller/Component');

class ImagesShell extends AppShell{

    public $tasks = array('Schema');

    function main() {

        $this->out('');
        $this->hr();

        while (empty($email)) {
            $email = $this->in('E-mail:');
            if (empty($email)) $this->out('E-mail must not be empty!');
        }

        while (empty($pwd1)) {
            $pwd1 = $this->in('Password:');
            if (empty($pwd1)) $this->out('Password must not be empty!');
        }

        while (empty($pwd2)) {
            $pwd2 = $this->in('Password Confirmation:');
            if ($pwd1 !== $pwd2) {
                $this->out('Passwort and confirmation do not match!');
                $pwd2 = NULL;
            }
        }
        $user['email'] = $email;
        $user['password'] = AuthComponent::password($pwd2);
        // we got all the data, let's create the user
        $this->Admin->create();
        if ($this->Admin->save($user)) {
            $this->out('Admin Admin created successfully!');
        } else {
            $this->out('ERROR while creating the Admin Admin!!!');
        }
    }
}