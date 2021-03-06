<?php

namespace App\Http\Controllers\Bugtracker;

use App\Http\Requests\CreateIssueRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\User;
use App\Project;
use App\Issue;

use App\Repositories\IssueRepository;

class IssuesController extends BugtrackerBaseController
{
    /**
     * Show all issues, assigned to the current project.
     *
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProjectIssues(Request $request, Project $project)
    {

        $issues = $project->issues()
            ->where('closed', (bool)$request->closed_visible)
            ->getOrdered()
            ->paginate(10);

        $issues->load('discussion', 'assignees', 'creator', 'type', 'priority', 'commentPoints');

        if ($request->ajax()) {
            return view('bugtracker.project.partials.issues', compact('issues', 'project'));
        }

        return view('bugtracker.project.issues', compact('issues', 'project'));
    }

    /**
     * Create new issue, and store it.
     *
     * @param CreateIssueRequest $request
     * @param Project $project
     */
    public function postCreateIssue(CreateIssueRequest $request, Project $project)
    {
        $project->issues()->create($request->all());

        if($request->ajax()) {
            return response("", 200);
        }

        return redirect()->back();
    }

    /**
     * Delete existing issue.
     *
     * @param Request $request
     * @param Project $project
     * @param Issue $issue
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeleteIssue(Request $request, Project $project, Issue $issue)
    {
        $issue->delete($issue);

        if($request->ajax()) {
            return response("", 200);
        }

        return redirect(route('project.issues', compact('project')));
    }

    /**
     * Close existing issue.
     *
     * @param Request $request
     * @param Project $project
     * @param Issue $issue
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closeIssue(Request $request, Project $project, Issue $issue)
    {
        $issue->close();
        session()->flash('message', 'Issue closed!');

        if($request->ajax()) {
            return response("", 200);
        }

        return redirect()->back();
    }

    /**
     * Open existing issue.
     *
     * @param Request $request
     * @param Project $project
     * @param Issue $issue
     * @return \Illuminate\Http\RedirectResponse
     */
    public function openIssue(Request $request, Project $project, Issue $issue)
    {
        $issue->open();
        session()->flash('message', 'Issue re-opened!');

        if($request->ajax()) {
            return response("", 200);
        }

        return redirect()->back();
    }

    public function attachUser(Request $request, Project $project, Issue $issue, User $user)
    {
        if(! $issue->assignees->contains($user)) {
            $issue->assignees()->attach($user);
        }
        return redirect()->back();
    }

    public function detachUser(Request $request, Project $project, Issue $issue, User $user)
    {
        $issue->assignees()->detach($user);
        return redirect()->back();
    }

}
