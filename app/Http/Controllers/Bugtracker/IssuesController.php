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

    public $issue_repository;

    public function __construct(IssueRepository $repository)
    {
        $this->issue_repository = $repository;
    }

    /*
     * Show all issues, assigned to current project
    */
    public function getProjectIssues(Request $request, Project $project)
    {

        $issues = $project->issues()
            ->where('closed', (bool)$request->closed_visible)
            ->getOrdered()
            ->paginate(10);

        if ($request->ajax()) {
            return view('bugtracker.project.partials.issues', compact('issues', 'project'));
        }

        return view('bugtracker.project.issues', compact('issues', 'project'));
    }

    /**
     * Create new issue, and store it
     *
     * @param CreateIssueRequest $request
     * @param Project $project
     */
    public function postCreateIssue(CreateIssueRequest $request, Project $project)
    {
        $project->issues()->create($request->all());
    }

    /*
     * Delete existing issue
    */
    public function postDeleteIssue(Project $project, Issue $issue)
    {

        $issue_repository = new IssueRepository;

        $issue_repository->delete($issue);

        $response = ['status' => true];
        
        return json_encode( $response );
    }

    public function closeIssue(Project $project, Issue $issue)
    {
        $issue->closed = true;
        $issue->update();

        session()->flash('message', 'Issue closed!');

        return redirect()->back();
    }

    public function openIssue(Project $project, Issue $issue)
    {
        $issue->closed = false;
        $issue->update();

        session()->flash('message', 'Issue re-opened!');

        return redirect()->back();
    }

}
