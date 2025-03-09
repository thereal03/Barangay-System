<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'Barangay Clearance', 
                'description' => 'A document issued by the barangay certifying that a person has no pending issues within the area. It is often required for various legal transactions and business applications.',
                'expiration_days' => 1 / 1440, // 1 minute for testing
            ],
            [
                'name' => 'Barangay ID', 
                'description' => 'A government-issued identification card for residents within a barangay. It serves as proof of residency and is used for various official purposes.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Barangay Certification', 
                'description' => 'A formal document issued by the barangay, confirming certain information about a person or property. It is commonly used for legal and administrative requirements.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Cedula', 
                'description' => 'A community tax certificate issued by the barangay. It serves as proof of payment of local taxes and is required for some official transactions.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Barangay Records', 
                'description' => 'Official documents or files maintained by the barangay. These include information about residents, businesses, and other matters within the jurisdiction.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'CBA Certification', 
                'description' => 'A certificate issued to confirm compliance with the Barangay\'s Community-Based Approach (CBA) programs. It is typically used in relation to community engagement and initiatives.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'BPO Barangay Protection Order', 
                'description' => 'A legal order issued by the barangay to protect individuals from harassment, violence, or threats. It is enforceable within the barangay\'s jurisdiction.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Health Services', 
                'description' => 'Medical and health-related services provided to residents by the barangay. These may include immunization, health consultations, and emergency care.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Solid Waste Collection', 
                'description' => 'The barangay\'s service for the collection and disposal of waste. This helps maintain cleanliness and proper waste management within the community.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Free Tarp for Achievers', 
                'description' => 'A program providing free tarpaulins to individuals or groups who have achieved notable accomplishments. It is a form of recognition by the barangay.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Educational Assistance', 
                'description' => 'Financial support provided by the barangay to assist students with their education. This may include scholarships or subsidies for tuition and other school expenses.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Barangay Road Maintenance', 
                'description' => 'The upkeep and repair of roads within the barangay. This ensures safe and accessible transportation routes for residents.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Women\'s Desk', 
                'description' => 'A designated area in the barangay that addresses issues related to women’s welfare. It focuses on empowerment, protection, and support for women in the community.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Barangay Business Permit', 
                'description' => 'A permit issued by the barangay for individuals or entities wishing to operate a business within its jurisdiction. It ensures that businesses comply with local regulations.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Certificate of Residency', 
                'description' => 'A document issued by the barangay confirming that a person resides within the community. It is often required for various legal and administrative purposes.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Certificate of Indigency', 
                'description' => 'A certificate issued to individuals who are considered indigent or financially disadvantaged. It may be required for accessing government assistance programs.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'First Time Job Seekers', 
                'description' => 'A program providing assistance to individuals seeking employment for the first time. It often includes skills training, job referrals, and other support services.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Emergency Services', 
                'description' => 'Immediate response and assistance provided by the barangay during emergencies. This may include medical, fire, or disaster response services.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Building Permit', 
                'description' => 'A permit issued by the barangay for construction or renovation projects. It ensures compliance with local building codes and regulations.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Peace and Order', 
                'description' => 'The barangay\'s efforts to maintain safety and security within its jurisdiction. This includes crime prevention and community policing initiatives.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Judicial', 
                'description' => 'Barangay services related to legal matters, such as mediation, conflict resolution, and barangay-based court proceedings.',
                'expiration_days' => 30, // 30 days
            ],
            [
                'name' => 'Environmental Services', 
                'description' => 'Services aimed at protecting and preserving the environment within the barangay. These include waste management, tree planting, and other eco-friendly initiatives.',
                'expiration_days' => 30, // 30 days
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}