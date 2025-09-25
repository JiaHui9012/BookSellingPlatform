<?php


namespace App\Policies;


use App\Models\User;
use App\Models\Book;
use Illuminate\Auth\Access\HandlesAuthorization;


class BookPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        if ($user->hasRole('Admin')) {
            return true;
        }
    }


    public function update(User $user, Book $book)
    {
        return $user->id === $book->seller_id;
    }


    public function delete(User $user, Book $book)
    {
        return $user->id === $book->seller_id;
    }
}
