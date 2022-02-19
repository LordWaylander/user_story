<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class createAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createAdmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commande pour créer un administrateur';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask("Nom d'utilisateur ?");
        $email = $this->ask("Mail ?");
        $password = $this->secret("Mot de passe ?");
        $passwordRepeat = $this->secret("Répétez mot de passe");

        while ($password != $passwordRepeat) {
            $this->info('Les mots de passes de correspondent pas');
            $password = $this->secret("Mot de passe ?");
            $passwordRepeat = $this->secret("Répétez mot de passe");
        }

        $adminList = User::where('role',1)->get();
        foreach ($adminList as $admin) {
            //dump($admin->email);
            if($email==$admin->email){
                return $this->error('Mail déjà utilisé');
            }
            if($name==$admin->username){
                return $this->error('Nom déjà utilisé');
            }
        }

        $user = new user;
        $user->name = $name;
        $user->email = $email;
        $user->username = $name;
        $user->role = 1;
        $user->password = bcrypt($password);
        $user->save();

        return Command::SUCCESS;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('package', InputArgument::REQUIRED, 'The name (vendor/name) of the package.'),
        );
    }
}
