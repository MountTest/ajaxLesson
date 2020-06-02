<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Role;
use Illuminate\Http\Request;
use Throwable;

class EmployeeController extends Controller
{
    public function main()
    {
        $roles = Role::all();
        $employees = Employee::where('status', true)->get();
        return view('main',
            [
                'roles' => $roles,
                'employees' => $employees,
            ]);
    }


    public function search(Request $request)
    {
        $searching_employees = Employee::where('status', true)->where('full_name', 'LIKE', '%' . $request->search_text . '%')->get();
        if (count($searching_employees)) {
            $status = true;
        } else {
            $status = false;
        }
        return response()->json([
            'status' => $status,
            'result_html' => $this->getTable($searching_employees),
        ]);
    }

    public function filter(Request $request)
    {
        if ($request->input('role_id') == 0) {
            $filter_employees = Employee::where('status', true)->get();
        } else {
            $filter_employees = Employee::where('role_id', $request->input('role_id'))->where('status', true)->get();
        }
        return response()->json(
            [
                'result_html' => $this->getTable($filter_employees)
            ]);

    }

    public function status(Request $request)
    {
        $employees = Employee::where('status', false)->get();
        return response()->json(
            [
                'result_html' => $this->getTable($employees),
            ]);
    }

    public function inversion_status(Request $request)
    {



        $changing_emp = Employee::find($request->input('emp_id'));
        $changing_emp->status = !$changing_emp->status;
        $changing_emp->save();
        return response()->json();
    }
    private function getTable($employees)
    {
        try {
            return view('response_table', ['employees' => $employees])->render();
        } catch (Throwable $e) {
            return '<table>
                        <tr>
                            <th>ФИО</th>
                            <th>Телефон</th>
                            <th>Статус</th>
                            <th>Должность</th>
                            <th>Действии</th>
                        </tr>
                    </table>';
        }
    }


}
