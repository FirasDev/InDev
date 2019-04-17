<?php

namespace TravelbuddyBundle\Form;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\TravelBuddy ;
use AppBundle\Entity\Pays ;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TravelBuddyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description')
            ->add('destination',ChoiceType::class, [
                'choices' => [

'Algeria'=>'Algeria',
'Angola'=>'Angola',
'Benin'=>'Benin',
'Botswana'=>'Botswana',
'Burkina'=>'Burkina',
'Burundi'=>'Burundi',
'Cameroon'=>'Cameroon',
'Cape Verde'=>'Cape Verde',
'Chad'=>'Chad',
'Comoros'=>'Comoros',
'Congo'=>'Congo',
'Djibouti'=>'Djibouti',
'Egypt'=>'Egypt',
'Equatorial Guinea'=>'Equatorial Guinea',
'Eritrea'=>'Eritrea',
'Ethiopia'=>'Ethiopia',
'Gabon'=>'Gabon',
'Gambia'=>'Gambia',
'Ghana'=>'Ghana',
'Guinea'=>'Guinea',
'Guinea-Bissau'=>'Guinea-Bissau',
'Ivory Coast'=>'Ivory Coast',
'Kenya'=>'Kenya',
'Lesotho'=>'Lesotho',
'Liberia'=>'Liberia',
'Libya'=>'Libya',
'Madagascar'=>'Madagascar',
'Malawi'=>'Malawi',
'Mali'=>'Mali',
'Mauritania'=>'Mauritania',
'Mauritius'=>'Mauritius',
'Morocco'=>'Morocco',
'Mozambique'=>'Mozambique',
'Namibia'=>'Namibia',
'Niger'=>'Niger',
'Nigeria'=>'Nigeria',
'Rwanda'=>'Rwanda',
'Senegal'=>'Senegal',
'Seychelles'=>'Seychelles',
'Sierra Leone'=>'Sierra Leone',
'Somalia'=>'Somalia',
'South Africa'=>'South Africa',
'Sudan'=>'Sudan',
'Swaziland'=>'Swaziland',
'Tanzania'=>'Tanzania',
'Togo'=>'Togo',
'Tunisia'=>'Tunisia',
'Uganda'=>'Uganda',
'Zambia'=>'Zambia',
'Zimbabwe'=>'Zimbabwe',
'Afghanistan'=>'Afghanistan',
'Bahrain'=>'Bahrain',
'Bangladesh'=>'Bangladesh',
'Bhutan'=>'Bhutan',
'Brunei'=>'Brunei',
'Burma'=>'Burma',
'Cambodia'=>'Cambodia',
'China'=>'China',
'East Timor'=>'East Timor',
'India'=>'India',
'Indonesia'=>'Indonesia',
'Iran'=>'Iran',
'Iraq'=>'Iraq',
'Israel'=>'Israel',
'Japan'=>'Japan',
'Jordan'=>'Jordan',
'Kazakhstan'=>'Kazakhstan',
'Korea, North'=>'Korea, North',
'Korea, South'=>'Korea, South',
'Kuwait'=>'Kuwait',
'Kyrgyzstan'=>'Kyrgyzstan',
'Laos'=>'Laos',
'Lebanon'=>'Lebanon',
'Malaysia'=>'Malaysia',
'Maldives'=>'Maldives',
'Mongolia'=>'Mongolia',
'Nepal'=>'Nepal',
'Oman'=>'Oman',
'Pakistan'=>'Pakistan',
'Philippines'=>'Philippines',
'Qatar'=>'Qatar',
'Russian Federation'=>'Russian Federation',
'Saudi Arabia'=>'Saudi Arabia',
'Singapore'=>'Singapore',
'Sri Lanka'=>'Sri Lanka',
'Syria'=>'Syria',
'Tajikistan'=>'Tajikistan',
'Thailand'=>'Thailand',
'Turkey'=>'Turkey',
'Turkmenistan'=>'Turkmenistan',
'United Arab Emirates'=>'United Arab Emirates',
'Uzbekistan'=>'Uzbekistan',
'Vietnam'=>'Vietnam',
'Yemen'=>'Yemen',
'Albania'=>'Albania',
'Andorra'=>'Andorra',
'Armenia'=>'Armenia',
'Austria'=>'Austria',
'Azerbaijan'=>'Azerbaijan',
'Belarus'=>'Belarus',
'Belgium'=>'Belgium',
'Bosnia and Herzegovina'=>'Bosnia and Herzegovina',
'Bulgaria'=>'Bulgaria',
'Croatia'=>'Croatia',
'Cyprus'=>'Cyprus',
'Czech Republic'=>'Czech Republic',
'Denmark'=>'Denmark',
'Estonia'=>'Estonia',
'Finland'=>'Finland',
'France'=>'France',
'Georgia'=>'Georgia',
'Germany'=>'Germany',
'Greece'=>'Greece',
'Hungary'=>'Hungary',
'Iceland'=>'Iceland',
'Ireland'=>'Ireland',
'Italy'=>'Italy',
'Latvia'=>'Latvia',
'Liechtenstein'=>'Liechtenstein',
'Lithuania'=>'Lithuania',
'Luxembourg'=>'Luxembourg',
'Macedonia'=>'Macedonia',
'Malta'=>'Malta',
'Moldova'=>'Moldova',
'Monaco'=>'Monaco',
'Montenegro'=>'Montenegro',
'Netherlands'=>'Netherlands',
'Norway'=>'Norway',
'Poland'=>'Poland',
'Portugal'=>'Portugal',
'Romania'=>'Romania',
'San Marino'=>'San Marino',
'Serbia'=>'Serbia',
'Slovakia'=>'Slovakia',
'Slovenia'=>'Slovenia',
'Spain'=>'Spain',
'Sweden'=>'Sweden',
'Switzerland'=>'Switzerland',
'Ukraine'=>'Ukraine',
'United Kingdom'=>'United Kingdom',
'Vatican City'=>'Vatican City',
'Antigua and Barbuda'=>'Antigua and Barbuda',
'Bahamas'=>'Bahamas',
'Barbados'=>'Barbados',
'Belize'=>'Belize',
'Canada'=>'Canada',
'Costa Rica'=>'Costa Rica',
'Cuba'=>'Cuba',
'Dominica'=>'Dominica',
'El Salvador'=>'El Salvador',
'Grenada'=>'Grenada',
'Guatemala'=>'Guatemala',
'Haiti'=>'Haiti',
'Honduras'=>'Honduras',
'Jamaica'=>'Jamaica',
'Mexico'=>'Mexico',
'Nicaragua'=>'Nicaragua',
'Panama'=>'Panama',
'Saint Kitts and Nevis'=>'Saint Kitts and Nevis',
'Saint Lucia'=>'Saint Lucia',
'United States'=>'United States',
'Australia'=>'Australia',
'Fiji'=>'Fiji',
'Kiribati'=>'Kiribati',
'Marshall Islands'=>'Marshall Islands',
'Micronesia'=>'Micronesia',
'Nauru'=>'Nauru',
'New Zealand'=>'New Zealand',
'Palau'=>'Palau',
'Papua New Guinea'=>'Papua New Guinea',
'Samoa'=>'Samoa',
'Solomon Islands'=>'Solomon Islands',
'Tonga'=>'Tonga',
'Tuvalu'=>'Tuvalu',
'Vanuatu'=>'Vanuatu',
'Argentina'=>'Argentina',
'Bolivia'=>'Bolivia',
'Brazil'=>'Brazil',
'Chile'=>'Chile',
'Colombia'=>'Colombia',
'Ecuador'=>'Ecuador',
'Guyana'=>'Guyana',
'Paraguay'=>'Paraguay',
'Peru'=>'Peru',
'Suriname'=>'Suriname',
'Uruguay'=>'Uruguay',
'Venezuela'=>'Venezuela'

                ]])

            ->add('dateDebut')
            ->add('dateFin')
            ->add('imageFile', VichImageType::class)
        ->add('Confirmer',SubmitType::class) ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TravelBuddy',

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_travelbuddy';
    }


}
