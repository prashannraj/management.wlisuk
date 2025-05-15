<table class='classic-table' style="margin-bottom:20px">
        <tbody>
            <tr>
                <td colspan="3">
                    <table>
                        <tbody>
                            <tr>

                                <td>
                                    @if(isset($export) && $export)
                                    <img src="{{public_path($company_info->logourl)}}" alt="">

                                    @else
                                    <img src="{{url($company_info->logourl)}}" alt="">

                                    @endif
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="100%">
                </td>
                <td width="350px">
                    <table>
                        <tbody>
                            <tr>
                                <td colspan="2"><b>{{$company_info->name}}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">{{$company_info->address}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">T: {{$company_info->telephone}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">E: {{$company_info->email}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">W: {{$company_info->website}}</td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>