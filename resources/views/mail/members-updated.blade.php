@component('mail::message')

    Memberships updated for the {{$organization->name}} {{$organization_type}}

    @component('mail::table')
        | Members Added | Members Removed |
        |:-------------:|:---------------:|
        @foreach($changed as $change)
            |
                @isset($change['added'])
                    {{$change['added']->name}}
                @endisset
            |
                @isset($change['removed'])
                    {{$change['removed']->name}}
                @endisset
            |
        @endforeach
    @endcomponent

@endcomponent