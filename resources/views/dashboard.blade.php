<x-app-layout>
    @push('custom_headers')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">


            @role('Intern')
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if($user->profile_status != 1)
                    <x-internee-tabs :user="$user"/>

                    <div class="px-6 mb-4 lg:px-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
                        <!-- resources/views/users/create.blade.php -->
                        <x-validation-errors class="mb-4 mt-4"/>
                        <form method="POST" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                                <div>
                                    <x-label for="name" value="Name" :required="true"/>
                                    <x-input id="name" name="name" class="block mt-1 w-full" type="text" required value="{{ $user->name }}"/>
                                </div>
                                <div>
                                    <x-label for="fathers_name" value="Father's Name" :required="true"/>
                                    <x-input id="fathers_name" name="fathers_name" required class="block mt-1 w-full" type="text" value="{{ $user->fathers_name }}"/>
                                </div>
                                <div>
                                    <x-label for="date_of_birth" value="Date of Birth" :required="true"/>
                                    <x-input id="date_of_birth" required max="2006-03-01" min="1997-03-01" name="date_of_birth" class="block mt-1 w-full" type="date" value="{{ $user->date_of_birth }}"/>
                                </div>

                                <div>
                                    <x-label for="nationality" value="Nationality" required :required="true"/>
                                    <select id="nationality" required name="nationality" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">-- select one --</option>
                                        @foreach($nationals as $key)
                                            <option value="{{ $key }}" @if($user->nationality == $key) selected @else
                                                {{ $key == "Pakistani"?"selected":"" }}
                                                    @endif>{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-label for="gender" value="Gender" :required="true"/>
                                    <select id="gender" name="gender" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a gender</option>
                                        <option value="Male" @if($user->gender == "Male") selected @endif>Male</option>
                                        <option value="Female" @if($user->gender == "Female") selected @endif>Female</option>
                                    </select>
                                </div>
                                <div>
                                    <x-label for="cnic_number" value="CNIC Number" :required="true"/>
                                    <x-input id="cnic_number" required name="cnic_number" class="block mt-1 w-full" type="text" value="{{ $user->cnic_number }}"/>
                                </div>
                                <div>
                                    <x-label for="marital_status" value="Marital Status" :required="true"/>
                                    <select id="marital_status" required name="marital_status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a marital status</option>
                                        <option value="Married" @if($user->marital_status == "Married") selected @endif>Married</option>
                                        <option value="Single" @if($user->marital_status == "Single") selected @endif>Single</option>
                                    </select>
                                </div>

                                <div>
                                    <x-label for="district" value="District" :required="true"/>
                                    <select id="district" required name="district" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a district</option>
                                        <option value="Muzaffarabad" @if($user->district == "Muzaffarabad") selected @endif>Muzaffarabad</option>
                                        <option value="Jhelum Valley" @if($user->district == "Jhelum Valley") selected @endif>Jhelum Valley</option>
                                        <option value="Neelum" @if($user->district == "Neelum") selected @endif>Neelum</option>
                                        <option value="Mirpur" @if($user->district == "Mirpur") selected @endif>Mirpur</option>
                                        <option value="Bhimber" @if($user->district == "Bhimber") selected @endif>Bhimber</option>
                                        <option value="Kotli" @if($user->district == "Kotli") selected @endif>Kotli</option>
                                        <option value="Poonch" @if($user->district == "Poonch") selected @endif>Poonch</option>
                                        <option value="Bagh" @if($user->district == "Bagh") selected @endif>Bagh</option>
                                        <option value="Haveli" @if($user->district == "Haveli") selected @endif>Haveli</option>
                                        <option value="Sudhanoti" @if($user->district == "Sudhanoti") selected @endif>Sudhanoti</option>
                                        <option value="Refugee" @if($user->district == "Refugee") selected @endif>Refugee</option>
                                    </select>
                                </div>

                                <div>
                                    <x-label for="district_of_domicile" value="District of Domicile" :required="true"/>
                                    <select id="district_of_domicile" required name="district_of_domicile" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a district of domicile</option>
                                        <option value="Muzaffarabad" @if($user->district == "Muzaffarabad") selected @endif>Muzaffarabad</option>
                                        <option value="Jhelum Valley" @if($user->district == "Jhelum Valley") selected @endif>Jhelum Valley</option>
                                        <option value="Neelum" @if($user->district == "Neelum") selected @endif>Neelum</option>
                                        <option value="Mirpur" @if($user->district == "Mirpur") selected @endif>Mirpur</option>
                                        <option value="Bhimber" @if($user->district == "Bhimber") selected @endif>Bhimber</option>
                                        <option value="Kotli" @if($user->district == "Kotli") selected @endif>Kotli</option>
                                        <option value="Poonch" @if($user->district == "Poonch") selected @endif>Poonch</option>
                                        <option value="Bagh" @if($user->district == "Bagh") selected @endif>Bagh</option>
                                        <option value="Haveli" @if($user->district == "Haveli") selected @endif>Haveli</option>
                                        <option value="Sudhanoti" @if($user->district == "Sudhanoti") selected @endif>Sudhanoti</option>
                                        <option value="Refugee" @if($user->district == "Refugee") selected @endif>Refugee</option>
                                    </select>
                                </div>


                                <div>
                                    <x-label for="contact_number" value="Contact Number" :required="true"/>
                                    <x-input id="contact_number" required maxlength="12" minlength="12" name="contact_number" class="block mt-1 w-full" type="text" pattern="\d{4}-\d{7}" title="Contact number must be in the format 0000-0000000" value="{{ $user->contact_number }}"/>
                                </div>


                                <div>
                                    <x-label for="phone_no" value="Phone Number" :required="false"/>
                                    <x-input id="phone_no" required name="phone_no" class="block mt-1 w-full" type="text" value="{{ $user->phone_no }}"/>
                                </div>
                                <div>
                                    <x-label for="religion" value="Religion" :required="true"/>
                                    <select name="religion" required id="religion" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a religion</option>
                                        <option value="islam" @if($user->religion == "islam") selected @endif>Islam</option>
                                        <option value="christianity" @if($user->religion == "christianity") selected @endif>Christianity</option>
                                        <option value="hinduism" @if($user->religion == "hinduism") selected @endif>Hinduism</option>
                                        <option value="buddhism" @if($user->religion == "buddhism") selected @endif>Buddhism</option>
                                        <option value="judaism" @if($user->religion == "judaism") selected @endif>Judaism</option>
                                    </select>
                                </div>
                                <div>
                                    <x-label for="mailing_address" required value="Mailing Address" :required="true"/>
                                    <textarea id="mailing_address" name="mailing_address" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ $user->mailing_address }}</textarea>
                                </div>


                                <div>
                                    <x-label for="profile_pic_1" value="Your Photo" :required="true"/>
                                    @if(!empty($user->profile_photo_path))
                                        <img id="profilePicture" style="border: 1px solid #747474;" height="150" width="150" src="{{ Storage::url($user->profile_photo_path) }}">
                                    @else
                                        <img id="profilePicture" style="border: 1px solid #747474;" height="150" width="150" src="/images/profile_avatar.png">
                                    @endif
                                    <x-input id="profile_pic_1" required name="profile_pic_1" class="block mt-1 w-full" type="file"/>
                                </div>

                                <div>
                                    <x-label for="cnic_front" value="CNIC Front" :required="true"/>
                                    @if(!empty($user->profile_photo_path))
                                        <img id="cnic_back_pic" style="border: 1px solid #747474;" height="150" width="150" src="{{ Storage::url($user->cnic_front_path) }}">
                                    @else
                                        <img id="cnic_back_pic" style="border: 1px solid #747474;" height="150" width="150" src="/images/front.png">
                                    @endif
                                    <x-input id="cnic_front" required name="cnic_front" class="block mt-1 w-full" type="file"/>
                                </div>


                                <div>
                                    <x-label for="cnic_back" value="CNIC Back" :required="true"/>
                                    @if(!empty($user->profile_photo_path))
                                        <img id="cnic_back_pic" style="border: 1px solid #747474;" height="150" width="150" src="{{ Storage::url($user->cnic_back_path) }}">
                                    @else
                                        <img id="cnic_back_pic" style="border: 1px solid #747474;" height="150" width="150" src="/images/back.png">
                                    @endif
                                    <x-input id="cnic_back" required name="cnic_back" class="block mt-1 w-full" type="file"/>
                                </div>


                            </div>
                            {{--                            onclick="return confirm('Are you sure you want to update the basic information of Intern?')"--}}
                            <div class="flex items-center justify-end mt-4">
                                @if(empty($user->cnic_number))
                                    <x-button class="ml-4" id="submit-btn"> {{ __('Save & Next') }} </x-button>
                                @else
                                    <x-button class="ml-4" id="submit-btn"> {{ __('Update & Next') }} </x-button>
                                @endif

                                @if(!empty($user->cnic_number))
                                    <a href="{{ route('education.edit', $user->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4" id="submit-btn"> {{ __('Next') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
            </div>
            @else
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="px-6 mb-4 pt-4 text-center font-bold lg:px-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
                        <x-status-message class="mb-4"/>
                        You have successfully submitted your application to HRMD of The Bank of Azad Jammu & Kashmir. <br>Your Application No is: {{ $user->id }}

                        <br>
                        @if($user->profile_status == 1 && $user->status == "Shortlisted" & $user->exam_taken == 0)
                            <a href="{{ route('start_session') }}" class="text-red-600 font-extrabold hover:underline text-2xl">Start Your Test</a>
                        @endif
                    </div>
                    @endif
                </div>
                @endrole

                @role('Super-Admin|admin')
                <div class="grid grid-cols-12 gap-6 ">
                    <a href="{{ route('candidate.index',['filter[profile_status]=0']) }}" class="transform  hover:scale-110 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">
                        <div class="p-5">
                            <div class="grid grid-cols-3 gap-1">
                                <div class="col-span-2">
                                    <div class="text-3xl font-bold leading-8">
                                        {{ App\Models\User::where('id','>',3)->where('profile_status', 0)->count(); }}
                                    </div>
                                    <div class="mt-1 text-base font-extrabold text-black">
                                        Candidates In-Process
                                    </div>
                                </div>
                                <div class="col-span-1 flex items-center justify-end">
                                    <img src="https://img.icons8.com/?size=128&id=123757&format=png" alt="employees on leave" class="h-12 w-12">
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('candidate.index',['filter[profile_status]=1']) }}" class="transform  hover:scale-110 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">
                        <div class="p-5">
                            <div class="grid grid-cols-3 gap-1">
                                <div class="col-span-2">
                                    <div class="text-3xl font-bold leading-8">
                                        {{ App\Models\User::where('profile_status', 1)->count(); }}
                                    </div>
                                    <div class="mt-1 text-base font-extrabold text-black">
                                        Total Candidates Applied
                                    </div>
                                </div>
                                <div class="col-span-1 flex items-center justify-end">
                                    <img src="https://img.icons8.com/?size=128&id=ZgPBQPTN8R9f&format=png" alt="employees on leave" class="h-12 w-12">
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('candidate.index') }}" class="transform  hover:scale-110 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">
                        <div class="p-5">
                            <div class="grid grid-cols-3 gap-1">
                                <div class="col-span-2">
                                    <div class="text-3xl font-bold leading-8">
                                        {{ App\Models\User::where('id','>',3)->count(); }}
                                    </div>
                                    <div class="mt-1 text-base font-extrabold text-black">
                                        Total Candidates
                                    </div>
                                </div>
                                <div class="col-span-1 flex items-center justify-end">
                                    <img src="https://img.icons8.com/?size=128&id=J0FhendbHVsR&format=png" alt="employees on leave" class="h-12 w-12">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="grid grid-cols-6 gap-6 mt-6">
                    <div class="col-span-6 md:col-span-6 lg:col-span-3">
                        <div class="bg-white rounded-lg shadow-lg p-4" id="chart">
                        </div>
                    </div>

                    <div class="col-span-6 md:col-span-6 lg:col-span-3">
                        <div class="bg-white rounded-lg shadow-lg p-4" id="chart_two">
                        </div>
                    </div>

                    <div class="col-span-6 md:col-span-6 lg:col-span-4">
                        <div class="bg-white rounded-lg shadow-lg p-4" id="chart_subjects">
                        </div>
                    </div>

                    <div class="col-span-6 md:col-span-6 lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-lg p-4" id="service_length_chart">
                        </div>
                    </div>






                </div>
                @endrole


        </div>
    </div>


    @push('modals')
        <script>
            // Add a script to format the CNIC input as 00000-0000000-0
            document.getElementById('cnic_number').addEventListener('input', function (e) {
                const cnicInput = e.target;
                let cnic = cnicInput.value.replace(/[^0-9]/g, '');
                if (cnic.length > 13) {
                    cnic = cnic.slice(0, 13);
                }
                const parts = cnic.match(/(\d{5})(\d{7})(\d{1})?/);
                if (parts) {
                    let formattedCnic = parts[1] + '-' + parts[2];
                    if (parts[3]) {
                        formattedCnic += '-' + parts[3];
                    }
                    cnicInput.value = formattedCnic;
                } else {
                    cnicInput.value = cnic;
                }
            });


        document.getElementById('cnic_front').addEventListener('change', function() {
            const file = this.files[0]; // Get the first file in the input
            if (file) { // Check if any file is selected
                const fileSize = file.size / 1024; // Get file size in KB
                if (fileSize > 512) { // Check if the file size is greater than 512 KB
                    alert('The file size must be less than 512 KB');
                    this.value = ''; // Clear the selected file
                }
            }
        });


        document.getElementById('cnic_back').addEventListener('change', function() {
            const file = this.files[0]; // Get the first file in the input
            if (file) { // Check if any file is selected
                const fileSize = file.size / 1024; // Get file size in KB
                if (fileSize > 512) { // Check if the file size is greater than 512 KB
                    alert('The file size must be less than 512 KB');
                    this.value = ''; // Clear the selected file
                }
            }
        });


        document.getElementById('profile_pic_1').addEventListener('change', function() {
            const file = this.files[0]; // Get the first file in the input
            if (file) { // Check if any file is selected
                const fileSize = file.size / 1024; // Get file size in KB
                if (fileSize > 512) { // Check if the file size is greater than 512 KB
                    alert('The file size must be less than 512 KB');
                    this.value = ''; // Clear the selected file
                }
            }
        });

        </script>
        @role('Super-Admin|admin')
        <script>
            var options = {
                   series: [@foreach($district_wise as $key => $value)
                {{ $value }},
            @endforeach],
                   chart: {
                    width: '100%',
                    height: '400px',
                    type: 'pie',
                 },
                  legend: {
                    position: 'right',
                },
                    title: {
                    text: 'AJK District Wise',
                    align: 'center',
                    margin: 0,
                    offsetX: 0,
                    offsetY: 0,
                    floating: false,
                    style: {
                        fontSize:  '16px',
                        fontWeight:  'bold',
                        fontFamily:  undefined,
                        color:  '#263238'
                    },
                },
                 labels: [@foreach($district_wise as $key => $value)
                '{{ $key }}',
            @endforeach],
                 responsive: [{
                   breakpoint: 480,
                   options: {
                     chart: {
                       width: 200
                     },
                     legend: {
                       position: 'bottom'
                     }
                   }
                 }]
                 };

                 var chart = new ApexCharts(document.querySelector("#chart"), options);
                 chart.render();


            // chart 2

            var options_two = {
               series: [@foreach($gender_wise as $key => $value)
                {{ $value }},
            @endforeach],
               chart: {
                width: '100%',
                height: '400px',
                type: 'pie',
             },
              legend: {
                position: 'right',
            },
                title: {
                text: 'Gender Wise Applied',
                align: 'center',
                margin: 0,
                offsetX: 0,
                offsetY: 0,
                floating: false,
                style: {
                    fontSize:  '16px',
                    fontWeight:  'bold',
                    fontFamily:  undefined,
                    color:  '#263238'
                },
            },
             labels: [@foreach($gender_wise as $key => $value)
                '{{ $key }}',
            @endforeach],
             responsive: [{
               breakpoint: 480,
               options: {
                 chart: {
                   width: 200
                 },
                 legend: {
                   position: 'bottom'
                 }
               }
             }]
             };

             var chart_two = new ApexCharts(document.querySelector("#chart_two"), options_two);
             chart_two.render();




            var service_length_options = {
                series: [ @foreach($finalAgeWiseData as $key => $value) {{ $value }}, @endforeach  ],
                dataLabels: {
                    formatter: function (val, opts) {
                        return opts.w.config.series[opts.seriesIndex]
                    },
                },
                chart: {
                    type: 'donut',
                    width: '100%',
                    height: '200px',
                    toolbar: {
                        show: true,
                        offsetX: 0,
                        offsetY: 0,
                        tools: {
                            download: true,
                            selection: true,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: true,
                            reset: true | '<img src="/static/icons/reset.png" width="20">',
                            customIcons: []
                        },
                        export: {
                            csv: {
                                filename: undefined,
                                columnDelimiter: ',',
                                headerCategory: 'category',
                                headerValue: 'value',
                                dateFormatter(timestamp) {
                                    return new Date(timestamp).toDateString()
                                }
                            },
                            svg: {
                                filename: undefined,
                            },
                            png: {
                                filename: undefined,
                            }
                        },
                        autoSelected: 'zoom'
                    },
                },
                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 90,
                        offsetY: 10
                    }
                },
                theme: {
                    monochrome: {
                        enabled: true,
                        color: '#059f0f',
                        shadeTo: 'dark',
                        shadeIntensity: 0.65
                    }
                },
                markers: {
                    colors: ['#F44336', '#E91E63', '#9C27B0']
                },
                                labels: [ @foreach($finalAgeWiseData as $key => $value) '{{ $key }}', @endforeach ],
                legend: {
                    position: 'right',

                },
                title: {
                    text: 'Total Age Wise - {{ $finalAgeWiseData['18-21 Years'] + $finalAgeWiseData['22-24 Years'] + $finalAgeWiseData['25-27 Years'] }}',
                    align: 'left',
                    margin: 0,
                    offsetX: 0,
                    offsetY: 0,
                    floating: false,
                    style: {
                        fontSize:  '16px',
                        fontWeight:  'bold',
                        fontFamily:  undefined,
                        color:  '#263238'
                    },
                },
                grid: {
                    padding: {
                        bottom: -70
                    }
                },
                responsive: [{
                    breakpoint: 678,
                    options: {
                        chart: {
                            width: '100%',
                            height:'180px'
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            var service_length_chart = new ApexCharts(document.querySelector("#service_length_chart"), service_length_options);
            service_length_chart.render();




      var options_subjects = {
          series: [{
          name: 'Total Applied',
          data: [@foreach($degreeCountsFormatted as $key => $value) {{ $value }}, @endforeach  ]
        }],
          chart: {
          type: 'bar',
          height: 350
        },

        title: {
        text: 'Major Subject Wise Applied',
        align: 'center',
        margin: 0,
        offsetX: 0,
        offsetY: 0,
        floating: false,
        style: {
            fontSize:  '16px',
            fontWeight:  'bold',
            fontFamily:  undefined,
            color:  '#263238'
        },
    },

        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: [@foreach($degreeCountsFormatted as $key => $value) '{{ $key }}', @endforeach],
        },
        yaxis: {
          title: {
            text: 'Total (Count)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "" + val + ""
            }
          }
        }
        };

        var chart_options_subjects = new ApexCharts(document.querySelector("#chart_subjects"), options_subjects);
        chart_options_subjects.render();


        </script>
        @endrole
    @endpush
</x-app-layout>
