<table class='classic-table w-100' style="margin-bottom:20px;width:100%">
        <tbody>
            <tr>
                <td colspan="3">
                    <table>
                        <tbody>
                            <tr>

                                <td>
                                    <img src="{{public_path($company->logourl)}}" alt="">
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
                                <td colspan="2"><b>{{$company->name}}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">{{$company->address}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">T: {{$company->telephone}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">E: {{$company->email}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">W: {{$company->website}}</td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>