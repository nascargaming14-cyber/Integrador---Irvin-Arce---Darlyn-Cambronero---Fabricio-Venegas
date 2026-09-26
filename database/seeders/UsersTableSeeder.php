<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_name' => 'Administrador',
                'email' => 'admin@integrador.com',
                'telephone' => '88880001',
                'password' => '$2y$12$MHDNP50l9fq6qIKcrlXjWuGno1Q.ivRae375xmSmYebBNT/e2Fxfq',
                'remember_token' => 'TY8wBkWjGgYETeRRSHqniS0HpGS8TCnAOux3Mte5MqvBGGmHPEI5sTLfuh7A',
                'email_verified_at' => NULL,
                'role_id' => 1,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-06-15 23:32:54',
            ),
            1 => 
            array (
                'id' => 2,
                'user_name' => 'Ventas',
                'email' => 'ventas@servigrama.com',
                'telephone' => '88880002',
                'password' => '$2y$12$Qy.FMp4H4xVf2VXT/hmUpucpdJM8Fxmrx.I/Zy9VXI.nl523fdKZe',
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'role_id' => 2,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-07-26 04:10:53',
            ),
            2 => 
            array (
                'id' => 3,
                'user_name' => 'Bodega',
                'email' => 'bodega@servigrama.com',
                'telephone' => '88880003',
                'password' => '$2y$12$epAd2gWs3M6AVE61gR4KUOXrYxzildhDR3OKt5xhX24Ubn5hFZ68S',
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'role_id' => 4,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-02 00:49:49',
            ),
            3 => 
            array (
                'id' => 6,
                'user_name' => 'super',
                'email' => 'super@servigrama.com',
                'telephone' => '63061653',
                'password' => '$2y$12$0WzDrhTJW.XAGIB.oDiXLuBSSWIuk0l.ki2YdX4r4ud1YsRTqqeNe',
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'role_id' => 3,
                'status_id' => 1,
                'created_at' => '2026-08-02 00:53:23',
                'updated_at' => '2026-08-02 00:53:23',
            ),
            4 => 
            array (
                'id' => 7,
                'user_name' => 'Gerencia',
                'email' => 'geren@servigrama.com',
                'telephone' => '79814120',
                'password' => '$2y$12$5OITyYAtFANNEBVTNCwxMuFeEa/NS0tkaDbqJk6v3GwbUkuHD2RV6',
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'role_id' => 6,
                'status_id' => 1,
                'created_at' => '2026-08-02 00:55:46',
                'updated_at' => '2026-08-02 00:55:46',
            ),
            5 => 
            array (
                'id' => 5,
                'user_name' => 'Admin',
                'email' => 'venegasfabricio93@gmail.com',
                'telephone' => NULL,
                'password' => '$2y$12$vIFXG70OhTl8kzVPaGUyNeUorPZ6pbqUN9THm7FeXY/95uVbnSEYO',
                'remember_token' => 'BwKoilFKnZ5ZPBzRENx21Fjo7EitT6pxxcD4gBxENlI1ioDv1owH7Bdh3HC1',
                'email_verified_at' => NULL,
                'role_id' => 1,
                'status_id' => 1,
                'created_at' => '2026-07-19 20:38:11',
                'updated_at' => '2026-09-24 17:11:46',
            ),
        ));
        
        
    }
}