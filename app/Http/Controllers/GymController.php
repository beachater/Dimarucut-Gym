<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gym;
use Illuminate\Http\Response;

class GymController extends Controller
{
    
    /** Add a new gym member to the database 
     * 
     * @param Request $request
     * @return Response 
    */
    public function add(Request $request)
    {
        Gym::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'membership_type' => $request->membership_type,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'notes' => $request->notes
        ]);

        return response([
            'message' => "Member added successfully"
        ], 200);
    }

    /** Get all gym members */
    public function get()
    {
        $members = Gym::get();

        return response([
             'members' => $members,
             'message' => "Members successfully retrieved"
        ], 200);
    }

    /** Update gym member details 
     * 
     * @param Request $request
     * @param int $id
     * @return Response
    */
    public function put(Request $request, int $id)
    {
        $memberInfo = Gym::find($id);

        $memberInfo->name = $request->name;
        $memberInfo->start_date = $request->start_date;
        $memberInfo->end_date = $request->end_date;
        $memberInfo->membership_type = $request->membership_type;
        $memberInfo->mobile_number = $request->mobile_number;
        $memberInfo->email = $request->email;
        $memberInfo->emergency_contact_name = $request->emergency_contact_name;
        $memberInfo->emergency_contact_number = $request->emergency_contact_number;
        $memberInfo->notes = $request->notes;
        $memberInfo->save();

        return response([
            'message' => "Member updated successfully"
        ], 200);
    }

    public function patch(Request $request, int $id)
    {
        // Find the gym member by ID
        $memberInfo = Gym::find($id);

        // Check if member exists
        if (!$memberInfo) {
            return response([
                'message' => "Member not found"
            ], 404);
        }

        // Update member info only if the fields are present in the request
        if ($request->has('name')) {
            $memberInfo->name = $request->name;
        }
        if ($request->has('start_date')) {
            $memberInfo->start_date = $request->start_date;
        }
        if ($request->has('end_date')) {
            $memberInfo->end_date = $request->end_date;
        }
        if ($request->has('membership_type')) {
            $memberInfo->membership_type = $request->membership_type;
        }
        if ($request->has('mobile_number')) {
            $memberInfo->mobile_number = $request->mobile_number;
        }
        if ($request->has('email')) {
            $memberInfo->email = $request->email;
        }
        if ($request->has('emergency_contact_name')) {
            $memberInfo->emergency_contact_name = $request->emergency_contact_name;
        }
        if ($request->has('emergency_contact_number')) {
            $memberInfo->emergency_contact_number = $request->emergency_contact_number;
        }
        if ($request->has('notes')) {
            $memberInfo->notes = $request->notes;
        }

        // Save the updated member info
        $memberInfo->save();

        return response([
            'message' => "Member updated successfully"
        ], 200);
    }

    /** Delete a gym member */
    public function delete(int $id)
    {
        $memberInfo = Gym::find($id);
        $memberInfo->delete();

        return response([
            'message' => "Member successfully removed"
        ], 200);
    }
}
