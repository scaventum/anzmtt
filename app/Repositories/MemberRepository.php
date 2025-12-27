<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository
{
  public function getAll(): object
  {
    return Member::all();
  }
  public function getExecutiveCommittee(): object
  {
    return Member::executiveCommittee()->get();
  }
  public function getAdvisoryBoard(): object
  {
    return Member::advisoryBoard()->get();
  }
}
