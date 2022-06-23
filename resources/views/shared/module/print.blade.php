<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Progress Report</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<section>

    <body>
        <div class="container">
            <div id="print" xmlns:margin-top="http://www.w3.org/1999/xhtml">

                <table width="100%">
                    <tr>
                        <td><img src="{{ asset('img/logo2.png') }}" style="max-height : 100px;"></td>

                        <td style="text-align: center; ">
                            <strong><span style="color: #1b0c80; font-size: 25px;"></span></strong><br />
                            <strong><span style="color: #1b0c80; font-size: 20px;">Preschool Academic Monitoring System
                                    (mSPAS)</span></strong><br />
                            <strong><span style="color: #000; font-size: 15px;">Wilayah Persekutuan Kuala
                                    Lumpur<i></i></span></strong><br />
                            <strong><span style="color: #000; font-size: 15px;"> {{ $module ? 'DETAILED REPORT SHEET' :
                                    'ACADEMIC REPORT SHEET'}}
                                </span></strong>
                        </td>
                        <td style="width: 100px; height: 100px; float: left;">
                            <img src="{{$student->picture}}" alt="..." width="100" height="100">
                        </td>
                    </tr>
                </table>
                <br />


                <div style="position: relative;  text-align: center; ">
                    <img src="{{ asset('img/logo2.png') }}"
                        style="max-width: 500px; max-height:600px; margin-top: 60px; position:absolute ; opacity: 0.2; margin-left: auto;margin-right: auto; left: 0; right: 0;" />
                </div>

                {{--
                <!-- SHEET BEGINS HERE-->--}}
                {{--
                <!--NAME , CLASS AND OTHER INFO -->--}}
                <table style="width:100%; border-collapse:collapse; ">
                    <tbody>
                        <tr>
                            <td><strong>NAME:</strong> {{$student->name}}</td>
                            <!-- <td><strong>ADM NO:</strong> </td> -->
                            <!-- <td><strong>HOUSE:</strong> </td> -->
                            <td><strong>CLASS:</strong> {{$student->class->name}}</td>
                        </tr>
                        @if($module)
                        <tr>
                            <!-- <td><strong>REPORT SHEET FOR 2022</strong> </td> -->
                            <td><strong>MONTH:</strong> {{$module->month->name ?? '-'}}</td>
                            <td><strong>SUBJECT: </strong>{{$module->subject->name}}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                @if( !$module )
                {{--Exam Table--}}
                <table style="width:100%; border-collapse:collapse; border: 1px solid #000; margin: 10px auto;"
                    border="1">
                    <thead>
                        <tr>
                            <th rowspan="2">SUBJECT</th>
                            <th rowspan="2">UPDATED DATE</th>
                            <th rowspan="2">PROGRESS</th>
                            <th rowspan="2">PERCENTAGE (%)</th>

                        </tr>
                        <!-- <tr>
                        <th>CA1(20)</th>
                        <th>CA2(20)</th>
                        <th>TOTAL(40)</th>
                    </tr> -->
                    </thead>
                    <tbody>
                        @foreach($student->modules as $subject)
                        <tr>
                            <td style="font-weight: bold">{{$subject->subject->name}}</td>
                            <td>2022-06-12 10:31:01</td>
                            <td>
                                @php
                                $progress = $student->getTotalModuleScore($subject) ?? 0;
                                $class = $progress >= 100 ? 'success' : 'orange';
                                @endphp
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-{{$class}}" style="width: {{ $progress }}%">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span>{{ $student->getTotalModuleScore($subject) ?? '0' }}%</span>
                            </td>
                        </tr>
                        @endforeach
                        </tr>
                        <!-- <tr>
                            <td colspan="3"><strong>TOTAL SCORES OBTAINED: </strong> </td>
                            <td colspan="3"><strong>FINAL AVERAGE: </strong> </td>
                            <td colspan="3"><strong>CLASS AVERAGE: </strong> </td>
                        </tr> -->
                    </tbody>
                </table>
                @else
                {{--Exam Table--}}
                <table style="width:100%; border-collapse:collapse; border: 1px solid #000; margin: 10px auto;"
                    border="1">
                    <thead>
                        <tr>
                            <th rowspan="2">PROGRESS MODULE</th>
                            <th rowspan="2">PROGRESS BAR</th>
                            <th rowspan="2">PERCENTAGE (%)</th>
                            <th rowspan="2">TARGET </th>

                        </tr>
                        <!-- <tr>
                            <th>CA1(20)</th>
                            <th>CA2(20)</th>
                            <th>TOTAL(40)</th>
                        </tr> -->
                    </thead>
                    <tbody>
                        @foreach($module->progresses as $progress)
                        <tr>
                            <td style="font-weight: bold">{{$progress->progress}}</td>
                            <td>
                                @php
                                $percentage = $student->getProgress($progress)->progress ?? 0;
                                $class = $percentage >= 100 ? 'success' : 'orange';
                                @endphp
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-{{$class}}" style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span>{{ $student->getProgress($progress)->progress ?? 0 }}%</span>
                            </td>
                            <td>{{$progress->target->name}}</td>
                            <!-- <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td> -->
                        </tr>
                        @endforeach
                        <!-- <tr>
                            <td colspan="3"><strong>TOTAL SCORES OBTAINED: </strong> </td>
                            <td colspan="3"><strong>FINAL AVERAGE: </strong> </td>
                            <td colspan="3"><strong>CLASS AVERAGE: </strong> </td>
                        </tr> -->
                    </tbody>
                </table>
                @endif
                <div style="margin-top: 25px; clear: both;"></div>

                {{-- COMMENTS & SIGNATURE --}}
                <div>
                    <table class="td-left" style="border-collapse:collapse;">
                        <tbody>
                            <!-- <tr>
                                <td><strong>TEACHER'S COMMENT:</strong></td>
                                <td> </td>
                            </tr> -->
                            <tr>
                                <td><strong>TEACHER:</strong> {{$student->class->teacher?->name ?? '-'}}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <script>
            // window.print();
        </script>
    </body>
</section>

</html>