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




        <h1> Terms Of Use </h1>

        <p>These terms of use are entered into by and between You and Strap Studios. ("Company," "we," or "us"). The following terms and conditions, together with any documents they expressly incorporate by reference (collectively, "Terms of Use"), govern your access to and use of strapstudios.com including any content, functionality,
           and services offered on or through strapstudios.com (the "Website"), whether as a guest or a registered user. </p>
        <p>Please read the Terms of Use carefully before you start to use the Website. By using the Website or by clicking to accept or 
          agree to the Terms of Use when this option is made available to you, you accept and agree to be bound and abide by these Terms of Use, our Privacy Policy..
           If you do not want to agree to these Terms of Use, the Privacy Policy, or the Terms of Sale, you must not access or use the Website. </p>
          <p>This Website is offered and available to users who are 18 years of age or older. By using this Website, you represent and warrant that you are of legal age to form a binding contract with the Company and meet all of the foregoing eligibility requirements. If you do not meet all of these requirements, you must not access or use the Website. </p>
          <h4>Changes to the Terms of Use </h4>
          <p>We may revise and update these Terms of Use from time to time in our sole discretion. All changes are effective immediately when we post them, and apply to all access to and use of the Website thereafter. However, any changes to the dispute resolution provisions set out in “<a href="https://issoyinc.com/pages/terms-of-use#a699054">Governing Law and Jurisdiction</a>” (below) will not apply to any disputes for which the parties have actual notice on or before the date the change is posted on the Website. </p>
          <p>Your continued use of the Website following the posting of revised Terms of Use means that you accept and agree to the changes. You are expected to check this page each time you access this Website so you are aware of any changes, as they are binding on you. </p>
          <h4>Accessing the Website and Account Security</h4>
          <p>We reserve the right to withdraw or amend this Website, and any service or material we provide on the Website, in our sole discretion without notice. We will not be liable if for any reason all or any part of the Website is unavailable at any time or for any period. From time to time, we may restrict access to some parts of the Website, or the entire Website, to users, including registered users.</p>
         
          <h5>You are responsible for both: </h5>
          <ul>
            <li>Making all arrangements necessary for you to have access to the Website.</li>
            <li>Ensuring that all persons who access the Website through your internet</li>
          </ul>
          <p>connection are aware of these Terms of Use and comply with them. </p>
          <p>To access the Website or some of the resources it offers, you may be asked to provide certain registration details or other information. It is a condition of your use of the Website that all the information you provide on the Website is correct, current, and complete. You agree that all information you provide to register with this Website or otherwise, including, but not limited to, through the use of any interactive features on the Website, is governed by our Privacy and you consent to all actions we take with respect to your information consistent with our Privacy Policy. </p>
          <p>If you choose, or are provided with, a user name, password, or any other piece of information as part of our security procedures, you must treat such information as confidential, and you must not disclose it to any other person or entity. You also acknowledge that your account is personal to you and agree not to provide any other person with access to this Website or portions of it using your user name, password, or other security information. You agree to notify us immediately of any unauthorized access to or use of your user name or password or any other breach of security. You also agree to ensure that you exit from your account at the end of each session. You should use particular caution when accessing your account from a public or shared computer so that others are not able to view or record your password or other personal information. </p>
          <p>We have the right to disable any user name, password, or other identifier, whether chosen by you or provided by us, at any time in our sole discretion for any or no reason, including if, in our opinion, you have violated any provision of these Terms of Use. </p>
          <h4>Intellectual Property Rights </h4>
          <p>The Website and its entire contents, features, and functionality (including but not limited to all information, software, text, displays, images, video, and audio, and the design, selection, and arrangement thereof) are owned by the Company, its licensors, or other providers of such material and are protected by United States and international copyright, trademark, patent, trade secret, and other intellectual property or proprietary rights laws.</p>
          <p>These Terms of Use permit you to use the Website solely for your own commercial use in connection with the purchase of goods made available for sale on the Website (a “permitted commercial use”). You must not reproduce, distribute, modify, create derivative works of, publicly display, publicly perform, republish, download, store, or transmit any of the material on our Website, except as follows: </p>
          
          <ul>
            <li>Your computer may temporarily store copies of such materials in RAM incidental to your accessing and viewing those materials.</li>
            <li>You may store files that are automatically cached by your Web browser for display enhancement purposes.</li>
            <li>You may print one copy of a reasonable number of pages of the Website for your own permitted commercial use and not for further reproduction, publication, or distribution.</li>
            <li>If we provide desktop, mobile, or other applications for download, you may download a single copy to your computer or mobile device solely for your own personal permitted commercial use, provided you agree to be bound by our end user license agreement for such applications.</li>
            <li>If we provide social media features with certain content, you may take such actions as are enabled by such features.</li>
          </ul>

          <h4>You must not:</h4>
          <ul>
            <li>Modify copies of any materials from this site.</li>      
            <li>Delete or alter any copyright, trademark, or other proprietary rights notices from copies of materials from this site.</li>      
          </ul>
          <p>If you wish to make any use of material on the Website other than that set out in this section, please address your request to: info@strapstudios.com. </p>
          <p>If you print, copy, modify, download, or otherwise use or provide any other person with access to any part of the Website in breach of the Terms of Use, your right to use the Website will stop immediately and you must, at our option, return or destroy any copies of the materials you have made. No right, title, or interest in or to the Website or any content on the Website is transferred to you, and all rights not expressly granted are reserved by the Company. Any use of the Website not expressly permitted by these Terms of Use is a breach of these Terms of Use and may violate copyright, trademark, and other laws. </p>
          <h4>Trademarks</h4>
          <p>The Company name and all related names, logos, product and service names, designs, and slogans on the Website are trademarks of the Company. You must not use such marks without the prior written permission of the Company. All other names, logos, product and service names, designs, and slogans on this Website are the trademarks of their respective owners. </p>
        
          <h4>Prohibited Uses</h4>
          <p>You may use the Website only for lawful purposes and in accordance with these Terms of Use. You agree not to use the Website:</p>
          <ul>
            <li>In any way that violates any applicable federal, state, local, or international law or regulation (including, without limitation, any laws regarding the export of data).</li>      
            <li>For the purpose of exploiting, harming, or attempting to exploit or harm minors in any way by exposing them to inappropriate content, asking for personally identifiable information, or otherwise. </li>      
            <li>To send, knowingly receive, upload, download, use, or re-use any material that does not comply with the Content Standards set out in these Terms of Use.</li>      
            <li>To transmit, or procure the sending of, any advertising or promotional material, including any "junk mail," "chain letter," "spam," or any other similar solicitation. 
</li>      
            <li>To impersonate or attempt to impersonate the Company, a Company employee, another user, or any other person or entity (including, without limitation, by using email addresses or screen names associated with any of the foregoing).</li>      
            <li>To engage in any other conduct that restricts or inhibits anyone's use or enjoyment of the Website, or which, as determined by us, may harm the Company or users of the Website, or expose them to liability.</li>      
             
          </ul>

          <h4>Additionally, you agree not to:</h4>
          <ul>
            <li>Use the Website in any manner that could disable, overburden, damage, or impair the site or interfere with any other party's use of the Website, including their ability to engage in real time activities through the Website.</li>       
            <li>Use any robot, spider, or other automatic device, process, or means to access the Website for any purpose, including monitoring or copying any of the material on the Website.</li>       
            <li>Use any manual process to monitor or copy any of the material on the Website, or for any other purpose not expressly authorized in these Terms of Use, without our prior written consent.</li>       
            <li>Use any device, software, or routine that interferes with the proper working of the Website. </li>       
            <li>Introduce any viruses, Trojan horses, worms, logic bombs, or other material that is malicious or technologically harmful.</li>       
            <li>Attempt to gain unauthorized access to, interfere with, damage, or disrupt any parts of the Website, the server on which the Website is stored, or any server, computer, or database connected to the Website.  </li>       
            <li>Attack the Website via a denial-of-service attack or a distributed denial-of-service attack.</li>       
            <li>Otherwise attempt to interfere with the proper working of the Website. </li>       
          </ul>

          
          <h4>Reliance on Information Posted</h4>
          <p>The information presented on or through the Website is made available solely for general information purposes. We do not warrant the accuracy, completeness, or usefulness of this information. Any reliance you place on such information is strictly at your own risk. We disclaim all liability and responsibility arising from any reliance placed on such materials by you or any other visitor to the Website, or by anyone who may be informed of any of its contents.</p>
          <p>This Website may include content provided by third parties, including materials provided by other users, bloggers, and third-party licensors, syndicators, aggregators, and/or reporting services.  All statements and/or opinions expressed in these materials, and all articles and responses to questions and other content, other than content provided by the Company, are solely the opinions and responsibility of the person or entity providing those materials.  These materials do not necessarily reflect the opinion of the Company.  We are not responsible, or liable to you or any third party, for the content or accuracy of any materials provided by any third parties. </p>
         
          <h4>Changes to the Website</h4>
          <p>We may update the content on this Website from time to time, but its content is not necessarily complete or up-to-date. Any of the material on the Website may be out of date at any given time, and we are under no obligation to update such material.  </p>
          
          <h4>Information About You and Your Visits to the Website </h4>
          <p>All information we collect on this Website is subject to our Privacy Policy. By using the Website, you consent to all actions taken by us with respect to your information in compliance with the Privacy Policy. </p>
  
          <h4>Online Purchases and Other Terms and Conditions </h4>
          <p>All purchases through our site or other transactions through the Website, or resulting from visits made by you, are governed by our Terms of Sale which are hereby incorporated into these Terms of Use.</p>
        
          <h4>Linking to the Website </h4>
          <p>You may not link to the Website without, and subject to the terms contained in, our prior written consent, which we may grant or withhold in our sole discretion.</p>
          <p>You agree to cooperate with us in causing any unauthorized framing or linking immediately to stop. We reserve the right to withdraw linking permission without notice.</p>
          <p>We may disable all or any social media features and any links at any time without notice in our discretion.</p>
       
       
          <h4>Links from the Website</h4>
          <p>If the Website contains links to other sites and resources provided by third parties, these links are provided for your convenience only. This includes links contained in advertisements, including banner advertisements and sponsored links. We have no control over the contents of those sites or resources, and accept no responsibility for them or for any loss or damage that may arise from your use of them. If you decide to access any of the third-party websites linked to this Website, you do so entirely at your own risk and subject to the terms and conditions of use for such websites. </p>
          
          
          <h4>Geographic Restrictions</h4>
          <p>The owner of the Website is based in the Abu Dhabi in the United Arab Emirates. If you access the Website from outside the UAE, you do so on your own initiative and are responsible for compliance with all applicable laws.</p>
         
         
          <h4>Disclaimer of Warranties </h4>
         <p>You understand that we cannot and do not guarantee or warrant that files available for downloading from the internet or the Website will be free of viruses or other destructive code. You are responsible for implementing sufficient procedures and checkpoints to satisfy your particular requirements for anti-virus protection and accuracy of data input and output, and for maintaining a means external to our site for any reconstruction of any lost data. TO THE FULLEST EXTENT PROVIDED BY LAW, WE WILL NOT BE LIABLE FOR ANY LOSS OR DAMAGE CAUSED BY A DISTRIBUTED DENIAL-OF-SERVICE ATTACK, VIRUSES, OR OTHER TECHNOLOGICALLY HARMFUL MATERIAL THAT MAY INFECT YOUR COMPUTER EQUIPMENT, COMPUTER PROGRAMS, DATA, OR OTHER PROPRIETARY MATERIAL DUE TO YOUR USE OF THE WEBSITE OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE OR TO YOUR DOWNLOADING OF ANY MATERIAL POSTED ON IT, OR ON ANY WEBSITE LINKED TO IT. </p>
         <p>YOUR USE OF THE WEBSITE, ITS CONTENT, AND ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE IS AT YOUR OWN RISK. THE WEBSITE, ITS CONTENT, AND ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE ARE PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS, WITHOUT ANY WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED. NEITHER THE COMPANY NOR ANY PERSON ASSOCIATED WITH THE COMPANY MAKES ANY WARRANTY OR REPRESENTATION WITH RESPECT TO THE COMPLETENESS, SECURITY, RELIABILITY, QUALITY, ACCURACY, OR AVAILABILITY OF THE WEBSITE. WITHOUT LIMITING THE FOREGOING, NEITHER THE COMPANY NOR ANYONE ASSOCIATED WITH THE COMPANY REPRESENTS OR WARRANTS THAT THE WEBSITE, ITS CONTENT, OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE WILL BE ACCURATE, RELIABLE, ERROR-FREE, OR UNINTERRUPTED, THAT DEFECTS WILL BE CORRECTED, THAT OUR SITE OR THE SERVER THAT MAKES IT AVAILABLE ARE FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS, OR THAT THE WEBSITE OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE WILL OTHERWISE MEET YOUR NEEDS OR EXPECTATIONS.  </p>
         <p>TO THE FULLEST EXTENT PROVIDED BY LAW, THE COMPANY HEREBY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, STATUTORY, OR OTHERWISE, INCLUDING BUT NOT LIMITED TO ANY WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT, AND FITNESS FOR PARTICULAR PURPOSE.</p>
         <p>THE FOREGOING DOES NOT AFFECT ANY WARRANTIES THAT CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE LAW.</p>
        
         <h4>Limitation on Liability   </h4>
          <p>EXCEPT WITH RESPECT TO ORDERS OF GOODS ON THE WEBSITE, TO THE FULLEST EXTENT PROVIDED BY LAW, IN NO EVENT WILL THE COMPANY, ITS AFFILIATES, OR THEIR LICENSORS, SERVICE PROVIDERS, EMPLOYEES, AGENTS, OFFICERS, OR DIRECTORS BE LIABLE FOR DAMAGES OF ANY KIND, UNDER ANY LEGAL THEORY, ARISING OUT OF OR IN CONNECTION WITH YOUR USE, OR INABILITY TO USE, THE WEBSITE, ANY WEBSITES LINKED TO IT, ANY CONTENT ON THE WEBSITE OR SUCH OTHER WEBSITES, INCLUDING ANY DIRECT, INDIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, INCLUDING BUT NOT LIMITED TO, PERSONAL INJURY, PAIN AND SUFFERING, EMOTIONAL DISTRESS, LOSS OF REVENUE, LOSS OF PROFITS, LOSS OF BUSINESS OR ANTICIPATED SAVINGS, LOSS OF USE, LOSS OF GOODWILL, LOSS OF DATA, AND WHETHER CAUSED BY TORT (INCLUDING NEGLIGENCE), BREACH OF CONTRACT, OR OTHERWISE, EVEN IF FORESEEABLE.  </p>
          <p>IN CONNECTION WITH THE SALE OF GOODS ON THIS WEBSITE, TO THE FULLEST EXTENT PROVIDED BY LAW, IN NO EVENT WILL THE COLLECTIVE LIABILITY OF THE COMPANY AND ITS SUBSIDIARIES AND AFFILIATES, AND THEIR LICENSORS, SERVICE PROVIDERS, EMPLOYEES, AGENTS, OFFICERS, AND DIRECTORS, TO ANY PARTY (REGARDLESS OF THE FORM OF ACTION, WHETHER IN CONTRACT, TORT, OR OTHERWISE) EXCEED THE PURCHASE PRICE OF THE ORDER(S) OF GOODS (NOT INCLUDING ANY SHIPPING OR HANDLING CHARGES) OUT OF WHICH LIABILITY AROSE. </p>
          <p>The limitation of liability set out above does not apply to liability resulting from our gross negligence or willful misconduct.</p>
          <p>THE FOREGOING DOES NOT AFFECT ANY LIABILITY THAT CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE LAW.</p>
         
          <h4>Indemnification </h4> 
          <p>You agree to defend, indemnify, and hold harmless the Company, its affiliates, licensors, and service providers, and its and their respective officers, directors, employees, contractors, agents, licensors, suppliers, successors, and assigns from and against any claims, liabilities, damages, judgments, awards, losses, costs, expenses, or fees (including reasonable attorneys' fees) arising out of or relating to your violation of these Terms of Use or your use of the Website, including, but not limited to, your User Contributions, any use of the Website's content, services, and products other than as expressly authorized in these Terms of Use, or your use of any information obtained from the Website.</p>
          
          <h4>Governing Law and Jurisdiction</h4> 
          <p>All matters relating to the Website and these Terms of Use, and any dispute or claim arising therefrom or related thereto (in each case, including non-contractual disputes or claims), shall be governed by and construed in accordance with the Local Law. </p>
          <p>Any legal suit, action, or proceeding arising out of, or related to, these Terms of Use or the Website shall be instituted exclusively in the courts of the UAE, although we retain the right to bring any suit, action, or proceeding against you for breach of these Terms of Use in your country of residence or any other relevant country. You waive any and all objections to the exercise of jurisdiction over you by such courts and to venue in such courts.</p>
          
          <h4>Arbitration</h4> 
          <p>At Company's sole discretion, it may require you to submit any disputes arising from these Terms of Use or use of the Website, including disputes arising from or concerning their interpretation, violation, invalidity, non-performance, or termination, to final and binding arbitration under the Rules of Arbitration of UAE.</p>
          <p>Except as otherwise required under applicable law, you expressly agree that: (a) class and collective action procedures shall not be asserted and will not apply in any arbitration pursuant to this Agreement; (b) you will not assert class or collective claims against the Company in court, in arbitration, or otherwise; (c) you shall only submit your own individual claims in arbitration and will not seek to represent the interests of any other person; (d) any claims by you will not be joined, consolidated, or heard together with the claims of any other person or entity; (e) no decision or arbitral award determining an issue with a similarly situated website user shall have any preclusive effect in any arbitration between you and the Company, and the Arbitrator shall have no authority to give preclusive effect to the issues determined in any other  arbitration. </p>
         
         
          <h4>Limitation on Time to File Claims</h4>
          <p>ANY CAUSE OF ACTION OR CLAIM YOU MAY HAVE ARISING OUT OF OR RELATING TO THESE TERMS OF USE OR THE WEBSITE MUST BE COMMENCED WITHIN 30 DAYS AFTER THE CAUSE OF ACTION ACCRUES; OTHERWISE, SUCH CAUSE OF ACTION OR CLAIM IS PERMANENTLY BARRED.</p>
            
          <h4>Waiver and Severability</h4>  
          <p>No waiver by the Company of any term or condition set out in these Terms of Use shall be deemed a further or continuing waiver of such term or condition or a waiver of any other term or condition, and any failure of the Company to assert a right or provision under these Terms of Use shall not constitute a waiver of such right or provision. </p>
          <p>If any provision of these Terms of Use is held by a court or other tribunal of competent jurisdiction to be invalid, illegal, or unenforceable for any reason, such provision shall be eliminated or limited to the minimum extent such that the remaining provisions of the Terms of Use will continue in full force and effect. </p>
          
          <h4>Entire Agreement</h4>   
          <p>The Terms of Use, and our Privacy Policy, constitute the sole and entire agreement between you and Strap Studios. regarding the Website and supersede all prior and contemporaneous understandings, agreements, representations, and warranties, both written and oral, regarding the Website. </p>
          
          <h4>Your Comments and Concerns </h4> 
          <p>This website is operated by Strap Studios., ADCP Tower C, 1704. Abu Dhabi, UAE  
All other feedback, comments, requests for technical support, and other communications relating to the Website should be directed to: info@strapstudios.com</p>
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