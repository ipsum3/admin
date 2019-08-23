<?php

namespace Ipsum\Admin\app\Http\Controllers;

use Ipsum\Admin\app\Classes\LogViewer;
use Gate;

class LogController extends AdminController
{
    /**
     * Lists all log files.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Gate::denies('show-logsq')) {
            abort('403');
        }

        $files = LogViewer::getFiles(true, true);

        return view('IpsumAdmin::log.index', compact('files'));
    }

    /**
     * Previews a log file.
     *
     * @throws \Exception
     */
    public function preview($file_name)
    {
        if (\Gate::denies('show-logs')) {
            abort('403');
        }

        LogViewer::setFile(decrypt($file_name));

        $logs = LogViewer::all();

        if (count($logs) <= 0) {
            abort(404, "Le fichier de logs n'existe pas");
        }

        $file_name = decrypt($file_name);

        return view('IpsumAdmin::log.preview', compact('logs', 'file_name'));
    }

    /**
     * Downloads a log file.
     *
     * @param $file_name
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($file_name)
    {
        if (\Gate::denies('show-logs')) {
            abort('403');
        }

        return response()->download(LogViewer::pathToLogFile(decrypt($file_name)));
    }

    /**
     * Deletes a log file.
     *
     * @param $file_name
     *
     * @throws \Exception
     *
     * @return string
     */
    public function delete($file_name)
    {
        if (\Gate::denies('show-logs')) {
            abort('403');
        }

        if (app('files')->delete(LogViewer::pathToLogFile(decrypt($file_name)))) {
            \Alert::warning("L'enregistrement a bien été supprimé")->flash();
            return back();
        }

        abort(404, "Le fichier de logs n'existe pas");
    }
}
