<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}

        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!--warapper-->
        <x-toast-notification />

        <!--company details section-->

        <div class="w-full mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-semibold mb-4">Company Information:</h2>
            <div class="mb-4">
                <p><strong>Owner:</strong> <a href="{{ $company->website }}" class="text-blue-600 hover:text-blue-900 underline" target="_blank">{{ $company->website }}</a></p>
            </div>
            <div class="mb-4">
                <p><strong>Address:</strong> {{ $company->address }}</p>
            </div>

            <div class="mb-4">
                <p><strong>Industry:</strong> {{ $company->industry }}</p>
            </div>

            <div class="mb-4">
                <p><strong>Website:</strong> <a href="{{ $company->website }}" class="text-blue-600 hover:text-blue-900 underline" target="_blank">{{ $company->website }}</a></p>
            </div>



            <!-- edit and archive buttons -->

            <div class="flex justify-end space-x-4">
                <a href="{{ route('company.edit', ['company' => $company->id,'redirectToList' =>'false']) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <form action="{{ route('company.destroy', $company->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to archive this company?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Archive
                    </button>
                </form>
                <a href="{{route('company.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back To List
                </a>
    </div>

    <!--tabs navigation-->
    <div class="mt-6 ">

        <ul class="flex space-x-4">

        <li>
            <a href="{{route('company.show', ['company' => $company->id, 'tab' => 'jobs'])}}"
            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'jobs' || request('tab') == '' ? 'bg-blue-500 text-white' : '' }}">Jobs</a>
        </li>

            <!--applications tab-->

        <li >
            <a href="{{route('company.show', ['company' => $company->id, 'tab' => 'applications'])}}"
            class="px-4 py-2 text-gray-800 font-semibold {{request('tab')=='applications' ? 'bg-blue-500 text-white' : '' }} ">Applications</a>
        </li>

        </ul>
        </div>

        <!--tab contents-->

        <div class="mt-4">

        <!--jobs tab-->
        <div id="jobs" class="{{request('tab') == 'jobs' || request('tab') == '' ?  'block' : 'hidden' }}">

            <table class="min-w-full  bg-gray-50 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Job Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Location</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Actions</th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Loop through jobs associated with the company -->
                    @forelse($company->jobVacancies as $job)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $job->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $job->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $job->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <a href="{{ route('job-vacancy.show', $job->id) }}" class="text-blue-600 hover:text-blue-900 mr-4">View</a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">No jobs found for this company.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!--applications tab-->
        <div id="applications" class="{{request('tab') == 'applications'  ? 'block' : 'hidden' }}" >

            <table class="min-w-full  bg-gray-50 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ApplicantName</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Job Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Actions</th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Loop through applications associated with the company's jobs -->

                    @forelse($company->jobapplications as $application)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $application->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $application->jobVacancy->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $application->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <a href="{{ route('job-application.show', $application->id) }}"
                                class="text-blue-600 hover:text-blue-900 mr-4">View</a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">No applications found for this company's jobs.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


        </div>
        </div>
        </div>
    </div>

</x-app-layout>

