<x-mail::message>
# Invoice for Repair Services

**Owner:** {{ $owner->name }}

---

### Car Number Plate: {{ $carNumberPlate }}

### Services Provided:
@foreach ($services as $service)
- **{{ $service->name }}**: ${{ $service->price }}
@endforeach

---

### Total Price: ${{ $totalPrice }}

Thank you for choosing our services!

---

For any questions or clarifications, feel free to contact us.

</x-mail::message>
