<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\MetaTags;

class ServicesController extends Controller
{
    use MetaTags;

    public function automation()
    {
        $this->setMetaTags([
            'title' => 'Automation Services - Open Clusters Systems | Business Process Automation',
            'description' => 'Transform your business with our automation services. Streamline processes, reduce costs, and increase efficiency with custom automation solutions.',
            'keywords' => 'Business Automation, Process Automation, Workflow Automation, RPA, Automation Solutions',
            'canonical' => route('services.automation'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => 'Business Automation Services',
                'description' => 'Custom automation solutions for business process optimization',
                'provider' => [
                    '@type' => 'Organization',
                    'name' => 'Open Clusters Systems'
                ],
                'serviceType' => 'Business Process Automation'
            ]
        ]);

        return view('services.automation');
    }

    public function itservice()
    {
        $this->setMetaTags([
            'title' => 'IT Services - Open Clusters Systems | Comprehensive IT Support',
            'description' => 'Professional IT services including infrastructure management, technical support, cloud solutions, and IT consulting for businesses.',
            'keywords' => 'IT Services, IT Support, IT Infrastructure, Cloud Services, IT Consulting, Technical Support',
            'canonical' => route('services.itservice'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => 'IT Support Services',
                'description' => 'Comprehensive IT support and infrastructure management',
                'provider' => [
                    '@type' => 'Organization',
                    'name' => 'Open Clusters Systems'
                ],
                'serviceType' => 'Information Technology Support'
            ]
        ]);

        return view('services.itservice');
    }

    public function itsolutions()
    {
        $this->setMetaTags([
            'title' => 'IT Solutions - Open Clusters Systems | Custom Technology Solutions',
            'description' => 'Innovative IT solutions tailored to your business needs. From system integration to digital transformation strategies.',
            'keywords' => 'IT Solutions, Technology Solutions, System Integration, Digital Transformation, Enterprise IT',
            'canonical' => route('services.itsolutions'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => 'Custom IT Solutions',
                'description' => 'Tailored technology solutions for business transformation',
                'provider' => [
                    '@type' => 'Organization',
                    'name' => 'Open Clusters Systems'
                ],
                'serviceType' => 'IT Solutions Development'
            ]
        ]);

        return view('services.itsolutions');
    }

    public function softwaredevelopment()
    {
        $this->setMetaTags([
            'title' => 'Software Development - Open Clusters Systems | Custom Software Solutions',
            'description' => 'Expert software development services including web applications, mobile apps, and enterprise software solutions built to your specifications.',
            'keywords' => 'Software Development, Custom Software, Web Development, Mobile App Development, Enterprise Software',
            'canonical' => route('services.softwaredevelopment'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => 'Software Development Services',
                'description' => 'Custom software development for web, mobile, and enterprise applications',
                'provider' => [
                    '@type' => 'Organization',
                    'name' => 'Open Clusters Systems'
                ],
                'serviceType' => 'Software Development'
            ]
        ]);

        return view('services.softwaredevelopment');
    }

    public function staffing()
    {
        $this->setMetaTags([
            'title' => 'IT Staffing - Open Clusters Systems | Technology Talent Solutions',
            'description' => 'Find skilled IT professionals and technology talent. Our staffing solutions help you build strong technical teams for your projects.',
            'keywords' => 'IT Staffing, Technology Talent, IT Recruitment, Tech Hiring, IT Consultants, Skilled Developers',
            'canonical' => route('services.staffing'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => 'IT Staffing Solutions',
                'description' => 'Technology talent acquisition and IT recruitment services',
                'provider' => [
                    '@type' => 'Organization',
                    'name' => 'Open Clusters Systems'
                ],
                'serviceType' => 'IT Staffing and Recruitment'
            ]
        ]);

        return view('services.staffing');
    }

    public function training()
    {
        $this->setMetaTags([
            'title' => 'IT Training - Open Clusters Systems | Technology Skills Development',
            'description' => 'Professional IT training programs to upskill your team. Learn the latest technologies and best practices from industry experts.',
            'keywords' => 'IT Training, Technology Training, Professional Development, Skills Training, Technical Courses',
            'canonical' => route('services.training'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => 'IT Training Programs',
                'description' => 'Professional technology training and skills development',
                'provider' => [
                    '@type' => 'Organization',
                    'name' => 'Open Clusters Systems'
                ],
                'serviceType' => 'Technology Training'
            ]
        ]);

        return view('services.training');
    }
}
