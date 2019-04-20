<?php

namespace App\Policies;

use App\Comment;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class CommentPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization,
        AuthorizesRelations;

    /**
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function index(User $user, string $type): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the comment.
     *
     * @param User  $user
     * @param Model $comment
     *
     * @return bool
     */
    public function read(User $user, Model $comment): bool
    {
        /* @var Comment $comment */
        return $user->can('read', [$comment->commentable]);
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function create(User $user, string $type): bool
    {
        $request = \request();

        if (!$request->has('commentable_type') || !$request->has('commentable_id')) {
            return false;
        }

        $commentable = $request->get('commentable_type')::find($request->get('commentable_id'));

        return $user->can('read', [$commentable]);
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param User  $user
     * @param Model $comment
     *
     * @return bool
     */
    public function update(User $user, Model $comment): bool
    {
        /* @var Comment $comment */
        return $user->characters()->where('id', $comment->character_id)->exists();
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param User  $user
     * @param Model $comment
     *
     * @return bool
     */
    public function delete(User $user, Model $comment): bool
    {
        /* @var Comment $comment */
        return $user->characters()->where('id', $comment->character_id)->exists();
    }

    /**
     * @param User    $user
     * @param Comment $comment
     *
     * @return bool
     */
    public function readCommentable(User $user, Comment $comment): bool
    {
        return $user->can('read', [$comment->commentable]);
    }

    /**
     * @param User    $user
     * @param Comment $comment
     *
     * @return bool
     */
    public function modifyCommentable(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * @param User    $user
     * @param Comment $comment
     *
     * @return bool
     */
    public function readCharacter(User $user, Comment $comment): bool
    {
        return $user->can('read', [$comment->commentable]);
    }

    /**
     * @param User    $user
     * @param Comment $comment
     *
     * @return bool
     */
    public function modifyCharacter(User $user, Comment $comment): bool
    {
        return false;
    }
}
