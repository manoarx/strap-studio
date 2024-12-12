@extends('layouts.frontend')

@section('content')
@php
$banner = App\Models\Banners::where('page','contact')->first();
@endphp
<section class="py-3 py-md-4 py-lg-5 contact_back"
  style="background-image: url({{ isset($banner->image) ? asset($banner->image) : '/frontend/assets/images/contact_background.png'}});">
  <div class="container cMN_wTh py-3 py-md-4 py-lg-5 ">

  </div>
</section>

<section class="pt-3 pt-md-4 pt-lg-5 contact_dtlz">
  <div class="container cMN_wTh pt-3 pt-md-4 pt-lg-5 ">

    <div class="cntct_wht_t">
      <div class="row prvCy_trm">




        <h1> Privacy Policy</h1>

        <h4>Introduction</h4>
        <p>Strap Studios. ("Company" or "We") respect your privacy and are committed to protecting it through our compliance with this policy. </p>
        <p>This policy describes the types of information we may collect from you or that you may provide when you visit the website Strap Studios.com (our "Website") and our practices for collecting, using, maintaining, protecting, and disclosing that information.</p>
        
        <p>This policy applies to information we collect: </p>
        <ul>
          <li>On this Website. </li>
          <li>In email, text, and other electronic messages between you and this Website. </li>
          <li>Through mobile and desktop applications you download from this Website, which provide dedicated non-browser-based interaction between you and this Website. </li>
        </ul>
        
        <p>It does not apply to information collected by: </p>
        <ul>
          <li>Us offline or through any other means; or</li>
          <li>Any third party, including through any application or content (including advertising) that may link to or be accessible from or on the Website. </li> 
        </ul>
        
        <p>Please read this policy carefully to understand our policies and practices regarding your information and how we will treat it. If you do not agree with our policies and practices, your choice is not to use our Website. By accessing or using this Website, you agree to this privacy policy. This policy may change from time to time (see “<a href="https://issoyinc.com/pages/privacy-policy#a286592">Changes to Our Privacy Policy</a>” below). Your continued use of this Website after we make changes is deemed to be acceptance of those changes, so please check the policy periodically for updates.  </p>
          
        <h4>Children Under the Age of 18</h4>
        <p>Our Website is not intended for users under 18 years of age. No one under age 18 may provide any personal information to or on the Website. We do not knowingly collect personal information from children under 18. If you are under 18, do not use or provide any information on this Website or through any of its features, register on the Website, make any purchases through the Website, use any of the interactive or public comment features of this Website, or provide any information about yourself to us, including your name, address, telephone number, email address, or any screen name or user name you may use. If we learn we have collected or received personal information from a child under 18 we will delete that information. If you believe we might have any information from or about a child under 18, please contact us at info@strapstudios.com </p>
        
        <h4>Information We Collect About You and How We Collect It</h4>
        <p>We collect several types of information from and about users of our Website, including information by which you may be personally identified, such as name, postal address, e-mail address, telephone number, Bradstreet number, billing address, shipping address or any other identifier by which you may be contacted online or offline ("personal information").: </p>
        
        <h4>We collect this information: </h4>
        <ul>
          <li>Directly from you when you provide it to us. </li>
          <li>Automatically as you navigate through the site. Information collected automatically may include visits to the website, order history, other usage details, and IP addresses.</li>
        </ul>
        <h4>Information You Provide to Us </h4>
        <p>The information we collect on or through our Website may include: </p>
        <ul>
          <li>Information that you provide by filling in forms on our Website. This includes information provided at the time of registering to use our Website or requesting further services. We may also ask you for information when you report a problem with our Website. </li>
          <li>Records and copies of your correspondence (including email addresses), if you contact us. </li>
          <li>Your responses to surveys that we might ask you to complete for research purposes. </li>
          <li>Details of transactions you carry out through our Website and of the fulfillment of your orders. You may be required to provide financial information before placing an order through our Website.</li>
        </ul>
        <h4>Information We Collect Through Automatic Data Collection Technologies </h4>
        <p>As you navigate through and interact with our Website, we may use automatic data collection technologies to collect certain information about your equipment, browsing actions, and patterns, including: </p>
          <ul>
            <li>Details of your visits to our Website, including traffic data, and other communication data and the resources that you access and use on the Website. </li>
            <li>Information about your computer and internet connection, including your IP address, operating system, and browser type. </li>
          </ul>
        <p>The information we collect automatically may include personal information. It helps us to improve our Website and to deliver a better and more personalized service, including by enabling us to:</p>
        <ul>
            <li>Estimate our audience size and usage patterns. </li>
            <li>Store information about your preferences, allowing us to customize our Website according to your individual interests. </li>
            <li>Speed up your searches.  </li>
            <li>Recognize you when you return to our Website.  </li>
          </ul>
        <p>Except as set forth above, we do not collect personal information automatically, but we may tie this information to personal information about you that we collect from other sources or you provide to us. </p>
       
        <h4>How We Use Your Information</h4>
        <p>We use information that we collect about you or that you provide to us, including any personal information: </p>
        <ul>
            <li>To present our Website and its contents to you.  </li>
            <li>To provide you with information, products, or services that you request from us.  </li>
            <li>To fulfill any other purpose for which you provide it. </li>
            <li>To provide you with notices about your account. </li>
            <li>To carry out our obligations and enforce our rights arising from any contracts entered into between you and us, including for billing and collection. </li>
            <li>To notify you about changes to our Website or any products or services we offer or provide though it.  </li>
            <li>To allow you to participate in interactive features on our Website.  </li>
            <li>In any other way we may describe when you provide the information.   </li>
            <li>For any other purpose with your consent.  </li>
          </ul>

          <p>We may also use your information to contact you about services that may be of interest to you.</p>

          <h4>Disclosure of Your Information</h4>
          <p>We may disclose personal information that we collect or you provide as described in this privacy policy: </p>
          <ul>
            <li>To a buyer or other successor in the event of a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Strap Studios assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which personal information held by Strap Studios about our Website users is among the assets transferred. </li>
            <li>To fulfill the purpose for which you provide it </li>
            <li>For any other purpose disclosed by us when you provide the information. </li>
            <li>With your consent. </li>
          </ul>
          <p>We may also disclose your personal information: </p>
          <ul>
            <li>To comply with any court order, law, or legal process, including to respond to any government or regulatory request. </li>
            <li>To enforce or apply our terms of use and other agreements, including for billing and collection purposes.  </li>
            <li>If we believe disclosure is necessary or appropriate to protect the rights, property, or safety of Strap Studios, our customers, or others. This includes exchanging information with other companies and organizations for the purposes of fraud protection and credit risk reduction. </li>
          </ul>
          
          <h4>Choices About Use and Disclose of Your Information </h4>
          <p>We strive to provide you with choices regarding the personal information you provide to us.  </p>
          <p>We do not control third parties' collection or use of your information to serve interest-based advertising. However these third parties may provide you with ways to choose not to have your information collected or used in this way. You can opt out of receiving targeted ads.</p>
          
          <h4>Accessing and Correcting Your Information</h4>
          <p>You may send us an email at info@strapstudios.com to request access to, correct or delete any personal information that you have provided to us. We cannot delete your personal information except by also deleting your user account. We may not accommodate a request to change information if we believe the change would violate any law or legal requirement or cause the information to be incorrect. </p>
          <p>Proper access and use of information provided on the Website is governed by our terms of use.</p>
         
          <h4>Data Security</h4>
          <p>We have implemented measures designed to secure your information from accidental loss and from unauthorized access, use, alteration, and disclosure.  </p>
          <p>The safety and security of your information also depends on you. Where we have given you (or where you have chosen) a password for access to certain parts of our Website, you are responsible for keeping this password confidential. We ask you not to share your password with anyone. We urge you to be careful about giving out information in public areas of the Website like forums. The information you share in public areas may be viewed by any user of the Website.</p>
          <p>Unfortunately, the transmission of information via the internet is not completely secure. Although we do our best to protect your personal information, we cannot guarantee the security of your personal information transmitted to our Website. Any transmission of personal information is at your own risk. We are not responsible for circumvention of any privacy settings or security measures contained on the Website.</p>
        
          <h4>Changes to Our Privacy Policy</h4>
          <p>It is our policy to post any changes we make to our privacy policy on this page. If we make material changes to how we treat our users' personal information, we will notify you through a notice on the Website home page. The date the privacy policy was last revised is identified at the top of the page. You are responsible for ensuring we have an up-to-date active and deliverable email address for you, and for periodically visiting our Website and this privacy policy to check for any changes. </p>
          
          <h4>Contact Information</h4>
          <p>To ask questions or comment about this privacy policy and our privacy practices, or to register a complaint or concern, contact us at: <a href="mailto:info@strapstudios.com">info@strapstudios.com</a>  </p>
          <p></p>



      </div>
    </div>
  </div>
</section>

@endsection     


@section('scripts')

<script>
    $(document).ready(function () {
      // sal();
      sal({
        threshold: 0.05,
      });

      
    });


  </script>

@endsection    