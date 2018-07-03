<?php

namespace App\Policies;

use App\Character;
use App\Comment;
use App\Http\Middleware\CheckCharacter;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CommentPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization,
        AuthorizesRelations;

    /**
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the comment.
     *
     * @param User    $user
     * @param Model   $comment
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $comment, Request $request): bool
    {
        /* @var Comment $comment */
        return $user->can('read', [$comment->commentable, $request]);
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        if (!$request->has('commentable_type') || !$request->has('commentable_id')) {
            return false;
        }

        $commentable = $request->get('commentable_type')::find($request->get('commentable_id'));

        return $user->can('read', [$commentable, $request]);
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param User    $user
     * @param Model   $comment
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $comment, Request $request): bool
    {
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER));

        /* @var Comment $comment */
        return $comment->character_id === $character->id;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param User    $user
     * @param Model   $comment
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $comment, Request $request): bool
    {
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER));

        /* @var Comment $comment */
        return $comment->character_id === $character->id;
    }

    /**
     * @param Comment $comment
     * @param Request $request
     *
     * @return bool
     */
    public function readCommentable(Comment $comment, Request $request): bool
    {
        return $request->user()->can('read', [$comment->commentable, $request]);
    }

    /**
     * @param Comment $comment
     * @param Request $request
     *
     * @return bool
     */
    public function modifyCommentable(Comment $comment, Request $request): bool
    {
        return false;
    }

    /**
     * @param Comment $comment
     * @param Request $request
     *
     * @return bool
     */
    public function readCharacter(Comment $comment, Request $request): bool
    {
        return $request->user()->can('read', [$comment->commentable, $request]);
    }

    /**
     * @param Comment $comment
     * @param Request $request
     *
     * @return bool
     */
    public function modifyCharacter(Comment $comment, Request $request): bool
    {
        return false;
    }
}
