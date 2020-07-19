<?php
namespace App\Model;

class Register extends \App\Model
{
  public function create($values) {
    
    $this->db->beginTransaction();

    $stmt = $this->db->prepare('insert into form_test (sei, mei, sex, birthday, car_license, tel, mail_address, pref, address, message, createdat) values (:sei, :mei, :sex, :birthday, :car_license, :tel, :mail_address, :pref, :address, :message, now());');

    $stmt->execute([
      ':sei' => $values['sei'],
      ':mei' => $values['mei'],
      ':sex' => $values['sex'],
      ':birthday' => str_pad($values['year'], 2, '0', STR_PAD_LEFT) . str_pad($values['month'], 2, '0', STR_PAD_LEFT) . str_pad($values['date'], 2, '0', STR_PAD_LEFT),
      ':car_license' => $values['car_license'],
      ':tel' => $values['tel'],
      ':mail_address' => $values['mail_address'],
      ':pref' => $values['pref'],
      ':address' => $values['address'],
      ':message' => $values['message']
    ]);

    $this->db->commit();

  }

  public function extract() {
    $stmt = $this->db->query('select id, sei, mei, sex, birthday, car_license, tel, mail_address, pref, address, message from form_test;');
    $stmt->execute();
    return $res = $stmt->fetchAll(\PDO::FETCH_NUM);
  }
}