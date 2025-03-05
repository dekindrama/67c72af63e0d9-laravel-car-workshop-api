<x-mail::message>
# New Task Assigned

Hi, {{ $mechanic->name }}

there is new task that has been assigned to you,


vehicle license plate: {{ $car->number_plate }}<br>
service: {{ $service->name }}



best regards,

Admin CAR WORKSHOP
</x-mail::message>
