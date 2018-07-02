<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-7-2
 * Time: 下午8:18
 */

namespace Press\Utils\Mime;


const MIMEDB = [
    'application/1d-interleaved-parityfec' =>
        [
            'source' => 'iana',
        ],
    'application/3gpdash-qoe-report+xml' =>
        [
            'source' => 'iana',
        ],
    'application/3gpp-ims+xml' =>
        [
            'source' => 'iana',
        ],
    'application/a2l' =>
        [
            'source' => 'iana',
        ],
    'application/activemessage' =>
        [
            'source' => 'iana',
        ],
    'application/alto-costmap+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/alto-costmapfilter+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/alto-directory+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/alto-endpointcost+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/alto-endpointcostparams+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/alto-endpointprop+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/alto-endpointpropparams+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/alto-error+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/alto-networkmap+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/alto-networkmapfilter+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/aml' =>
        [
            'source' => 'iana',
        ],
    'application/andrew-inset' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ez',
                ],
        ],
    'application/applefile' =>
        [
            'source' => 'iana',
        ],
    'application/applixware' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'aw',
                ],
        ],
    'application/atf' =>
        [
            'source' => 'iana',
        ],
    'application/atfx' =>
        [
            'source' => 'iana',
        ],
    'application/atom+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'atom',
                ],
        ],
    'application/atomcat+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'atomcat',
                ],
        ],
    'application/atomdeleted+xml' =>
        [
            'source' => 'iana',
        ],
    'application/atomicmail' =>
        [
            'source' => 'iana',
        ],
    'application/atomsvc+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'atomsvc',
                ],
        ],
    'application/atxml' =>
        [
            'source' => 'iana',
        ],
    'application/auth-policy+xml' =>
        [
            'source' => 'iana',
        ],
    'application/bacnet-xdd+zip' =>
        [
            'source' => 'iana',
        ],
    'application/batch-smtp' =>
        [
            'source' => 'iana',
        ],
    'application/bdoc' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'bdoc',
                ],
        ],
    'application/beep+xml' =>
        [
            'source' => 'iana',
        ],
    'application/calendar+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/calendar+xml' =>
        [
            'source' => 'iana',
        ],
    'application/call-completion' =>
        [
            'source' => 'iana',
        ],
    'application/cals-1840' =>
        [
            'source' => 'iana',
        ],
    'application/cbor' =>
        [
            'source' => 'iana',
        ],
    'application/cccex' =>
        [
            'source' => 'iana',
        ],
    'application/ccmp+xml' =>
        [
            'source' => 'iana',
        ],
    'application/ccxml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ccxml',
                ],
        ],
    'application/cdfx+xml' =>
        [
            'source' => 'iana',
        ],
    'application/cdmi-capability' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cdmia',
                ],
        ],
    'application/cdmi-container' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cdmic',
                ],
        ],
    'application/cdmi-domain' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cdmid',
                ],
        ],
    'application/cdmi-object' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cdmio',
                ],
        ],
    'application/cdmi-queue' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cdmiq',
                ],
        ],
    'application/cdni' =>
        [
            'source' => 'iana',
        ],
    'application/cea' =>
        [
            'source' => 'iana',
        ],
    'application/cea-2018+xml' =>
        [
            'source' => 'iana',
        ],
    'application/cellml+xml' =>
        [
            'source' => 'iana',
        ],
    'application/cfw' =>
        [
            'source' => 'iana',
        ],
    'application/clue_info+xml' =>
        [
            'source' => 'iana',
        ],
    'application/cms' =>
        [
            'source' => 'iana',
        ],
    'application/cnrp+xml' =>
        [
            'source' => 'iana',
        ],
    'application/coap-group+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/coap-payload' =>
        [
            'source' => 'iana',
        ],
    'application/commonground' =>
        [
            'source' => 'iana',
        ],
    'application/conference-info+xml' =>
        [
            'source' => 'iana',
        ],
    'application/cose' =>
        [
            'source' => 'iana',
        ],
    'application/cose-key' =>
        [
            'source' => 'iana',
        ],
    'application/cose-key-set' =>
        [
            'source' => 'iana',
        ],
    'application/cpl+xml' =>
        [
            'source' => 'iana',
        ],
    'application/csrattrs' =>
        [
            'source' => 'iana',
        ],
    'application/csta+xml' =>
        [
            'source' => 'iana',
        ],
    'application/cstadata+xml' =>
        [
            'source' => 'iana',
        ],
    'application/csvm+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/cu-seeme' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cu',
                ],
        ],
    'application/cybercash' =>
        [
            'source' => 'iana',
        ],
    'application/dart' =>
        [
            'compressible' => true,
        ],
    'application/dash+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mpd',
                ],
        ],
    'application/dashdelta' =>
        [
            'source' => 'iana',
        ],
    'application/davmount+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'davmount',
                ],
        ],
    'application/dca-rft' =>
        [
            'source' => 'iana',
        ],
    'application/dcd' =>
        [
            'source' => 'iana',
        ],
    'application/dec-dx' =>
        [
            'source' => 'iana',
        ],
    'application/dialog-info+xml' =>
        [
            'source' => 'iana',
        ],
    'application/dicom' =>
        [
            'source' => 'iana',
        ],
    'application/dicom+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/dicom+xml' =>
        [
            'source' => 'iana',
        ],
    'application/dii' =>
        [
            'source' => 'iana',
        ],
    'application/dit' =>
        [
            'source' => 'iana',
        ],
    'application/dns' =>
        [
            'source' => 'iana',
        ],
    'application/docbook+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'dbk',
                ],
        ],
    'application/dskpp+xml' =>
        [
            'source' => 'iana',
        ],
    'application/dssc+der' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dssc',
                ],
        ],
    'application/dssc+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xdssc',
                ],
        ],
    'application/dvcs' =>
        [
            'source' => 'iana',
        ],
    'application/ecmascript' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'ecma',
                ],
        ],
    'application/edi-consent' =>
        [
            'source' => 'iana',
        ],
    'application/edi-x12' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'application/edifact' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'application/efi' =>
        [
            'source' => 'iana',
        ],
    'application/emergencycalldata.comment+xml' =>
        [
            'source' => 'iana',
        ],
    'application/emergencycalldata.control+xml' =>
        [
            'source' => 'iana',
        ],
    'application/emergencycalldata.deviceinfo+xml' =>
        [
            'source' => 'iana',
        ],
    'application/emergencycalldata.ecall.msd' =>
        [
            'source' => 'iana',
        ],
    'application/emergencycalldata.providerinfo+xml' =>
        [
            'source' => 'iana',
        ],
    'application/emergencycalldata.serviceinfo+xml' =>
        [
            'source' => 'iana',
        ],
    'application/emergencycalldata.subscriberinfo+xml' =>
        [
            'source' => 'iana',
        ],
    'application/emergencycalldata.veds+xml' =>
        [
            'source' => 'iana',
        ],
    'application/emma+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'emma',
                ],
        ],
    'application/emotionml+xml' =>
        [
            'source' => 'iana',
        ],
    'application/encaprtp' =>
        [
            'source' => 'iana',
        ],
    'application/epp+xml' =>
        [
            'source' => 'iana',
        ],
    'application/epub+zip' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'epub',
                ],
        ],
    'application/eshop' =>
        [
            'source' => 'iana',
        ],
    'application/exi' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'exi',
                ],
        ],
    'application/fastinfoset' =>
        [
            'source' => 'iana',
        ],
    'application/fastsoap' =>
        [
            'source' => 'iana',
        ],
    'application/fdt+xml' =>
        [
            'source' => 'iana',
        ],
    'application/fido.trusted-apps+json' =>
        [
            'compressible' => true,
        ],
    'application/fits' =>
        [
            'source' => 'iana',
        ],
    'application/font-sfnt' =>
        [
            'source' => 'iana',
        ],
    'application/font-tdpfr' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pfr',
                ],
        ],
    'application/font-woff' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'woff',
                ],
        ],
    'application/font-woff2' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'woff2',
                ],
        ],
    'application/framework-attributes+xml' =>
        [
            'source' => 'iana',
        ],
    'application/geo+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'geojson',
                ],
        ],
    'application/geo+json-seq' =>
        [
            'source' => 'iana',
        ],
    'application/gml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gml',
                ],
        ],
    'application/gpx+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'gpx',
                ],
        ],
    'application/gxf' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'gxf',
                ],
        ],
    'application/gzip' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'gz',
                ],
        ],
    'application/h224' =>
        [
            'source' => 'iana',
        ],
    'application/held+xml' =>
        [
            'source' => 'iana',
        ],
    'application/http' =>
        [
            'source' => 'iana',
        ],
    'application/hyperstudio' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'stk',
                ],
        ],
    'application/ibe-key-request+xml' =>
        [
            'source' => 'iana',
        ],
    'application/ibe-pkg-reply+xml' =>
        [
            'source' => 'iana',
        ],
    'application/ibe-pp-data' =>
        [
            'source' => 'iana',
        ],
    'application/iges' =>
        [
            'source' => 'iana',
        ],
    'application/im-iscomposing+xml' =>
        [
            'source' => 'iana',
        ],
    'application/index' =>
        [
            'source' => 'iana',
        ],
    'application/index.cmd' =>
        [
            'source' => 'iana',
        ],
    'application/index.obj' =>
        [
            'source' => 'iana',
        ],
    'application/index.response' =>
        [
            'source' => 'iana',
        ],
    'application/index.vnd' =>
        [
            'source' => 'iana',
        ],
    'application/inkml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ink',
                    1 => 'inkml',
                ],
        ],
    'application/iotp' =>
        [
            'source' => 'iana',
        ],
    'application/ipfix' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ipfix',
                ],
        ],
    'application/ipp' =>
        [
            'source' => 'iana',
        ],
    'application/isup' =>
        [
            'source' => 'iana',
        ],
    'application/its+xml' =>
        [
            'source' => 'iana',
        ],
    'application/java-archive' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'jar',
                    1 => 'war',
                    2 => 'ear',
                ],
        ],
    'application/java-serialized-object' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'ser',
                ],
        ],
    'application/java-vm' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'class',
                ],
        ],
    'application/javascript' =>
        [
            'source' => 'iana',
            'charset' => 'UTF-8',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'js',
                ],
        ],
    'application/jf2feed+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/jose' =>
        [
            'source' => 'iana',
        ],
    'application/jose+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/jrd+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/json' =>
        [
            'source' => 'iana',
            'charset' => 'UTF-8',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'json',
                    1 => 'map',
                ],
        ],
    'application/json-patch+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/json-seq' =>
        [
            'source' => 'iana',
        ],
    'application/json5' =>
        [
            'extensions' =>
                [
                    0 => 'json5',
                ],
        ],
    'application/jsonml+json' =>
        [
            'source' => 'apache',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'jsonml',
                ],
        ],
    'application/jwk+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/jwk-set+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/jwt' =>
        [
            'source' => 'iana',
        ],
    'application/kpml-request+xml' =>
        [
            'source' => 'iana',
        ],
    'application/kpml-response+xml' =>
        [
            'source' => 'iana',
        ],
    'application/ld+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'jsonld',
                ],
        ],
    'application/lgr+xml' =>
        [
            'source' => 'iana',
        ],
    'application/link-format' =>
        [
            'source' => 'iana',
        ],
    'application/load-control+xml' =>
        [
            'source' => 'iana',
        ],
    'application/lost+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'lostxml',
                ],
        ],
    'application/lostsync+xml' =>
        [
            'source' => 'iana',
        ],
    'application/lxf' =>
        [
            'source' => 'iana',
        ],
    'application/mac-binhex40' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'hqx',
                ],
        ],
    'application/mac-compactpro' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cpt',
                ],
        ],
    'application/macwriteii' =>
        [
            'source' => 'iana',
        ],
    'application/mads+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mads',
                ],
        ],
    'application/manifest+json' =>
        [
            'charset' => 'UTF-8',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'webmanifest',
                ],
        ],
    'application/marc' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mrc',
                ],
        ],
    'application/marcxml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mrcx',
                ],
        ],
    'application/mathematica' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ma',
                    1 => 'nb',
                    2 => 'mb',
                ],
        ],
    'application/mathml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mathml',
                ],
        ],
    'application/mathml-content+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mathml-presentation+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-associated-procedure-description+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-deregister+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-envelope+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-msk+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-msk-response+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-protection-description+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-reception-report+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-register+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-register-response+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-schedule+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbms-user-service-description+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mbox' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mbox',
                ],
        ],
    'application/media-policy-dataset+xml' =>
        [
            'source' => 'iana',
        ],
    'application/media_control+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mediaservercontrol+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mscml',
                ],
        ],
    'application/merge-patch+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/metalink+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'metalink',
                ],
        ],
    'application/metalink4+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'meta4',
                ],
        ],
    'application/mets+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mets',
                ],
        ],
    'application/mf4' =>
        [
            'source' => 'iana',
        ],
    'application/mikey' =>
        [
            'source' => 'iana',
        ],
    'application/mods+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mods',
                ],
        ],
    'application/moss-keys' =>
        [
            'source' => 'iana',
        ],
    'application/moss-signature' =>
        [
            'source' => 'iana',
        ],
    'application/mosskey-data' =>
        [
            'source' => 'iana',
        ],
    'application/mosskey-request' =>
        [
            'source' => 'iana',
        ],
    'application/mp21' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'm21',
                    1 => 'mp21',
                ],
        ],
    'application/mp4' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mp4s',
                    1 => 'm4p',
                ],
        ],
    'application/mpeg4-generic' =>
        [
            'source' => 'iana',
        ],
    'application/mpeg4-iod' =>
        [
            'source' => 'iana',
        ],
    'application/mpeg4-iod-xmt' =>
        [
            'source' => 'iana',
        ],
    'application/mrb-consumer+xml' =>
        [
            'source' => 'iana',
        ],
    'application/mrb-publish+xml' =>
        [
            'source' => 'iana',
        ],
    'application/msc-ivr+xml' =>
        [
            'source' => 'iana',
        ],
    'application/msc-mixer+xml' =>
        [
            'source' => 'iana',
        ],
    'application/msword' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'doc',
                    1 => 'dot',
                ],
        ],
    'application/mud+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/mxf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mxf',
                ],
        ],
    'application/n-quads' =>
        [
            'source' => 'iana',
        ],
    'application/n-triples' =>
        [
            'source' => 'iana',
        ],
    'application/nasdata' =>
        [
            'source' => 'iana',
        ],
    'application/news-checkgroups' =>
        [
            'source' => 'iana',
        ],
    'application/news-groupinfo' =>
        [
            'source' => 'iana',
        ],
    'application/news-transmission' =>
        [
            'source' => 'iana',
        ],
    'application/nlsml+xml' =>
        [
            'source' => 'iana',
        ],
    'application/nss' =>
        [
            'source' => 'iana',
        ],
    'application/ocsp-request' =>
        [
            'source' => 'iana',
        ],
    'application/ocsp-response' =>
        [
            'source' => 'iana',
        ],
    'application/octet-stream' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'bin',
                    1 => 'dms',
                    2 => 'lrf',
                    3 => 'mar',
                    4 => 'so',
                    5 => 'dist',
                    6 => 'distz',
                    7 => 'pkg',
                    8 => 'bpk',
                    9 => 'dump',
                    10 => 'elc',
                    11 => 'deploy',
                    12 => 'exe',
                    13 => 'dll',
                    14 => 'deb',
                    15 => 'dmg',
                    16 => 'iso',
                    17 => 'img',
                    18 => 'msi',
                    19 => 'msp',
                    20 => 'msm',
                    21 => 'buffer',
                ],
        ],
    'application/oda' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'oda',
                ],
        ],
    'application/odx' =>
        [
            'source' => 'iana',
        ],
    'application/oebps-package+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'opf',
                ],
        ],
    'application/ogg' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'ogx',
                ],
        ],
    'application/omdoc+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'omdoc',
                ],
        ],
    'application/onenote' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'onetoc',
                    1 => 'onetoc2',
                    2 => 'onetmp',
                    3 => 'onepkg',
                ],
        ],
    'application/oxps' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'oxps',
                ],
        ],
    'application/p2p-overlay+xml' =>
        [
            'source' => 'iana',
        ],
    'application/parityfec' =>
        [
            'source' => 'iana',
        ],
    'application/passport' =>
        [
            'source' => 'iana',
        ],
    'application/patch-ops-error+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xer',
                ],
        ],
    'application/pdf' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'pdf',
                ],
        ],
    'application/pdx' =>
        [
            'source' => 'iana',
        ],
    'application/pgp-encrypted' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'pgp',
                ],
        ],
    'application/pgp-keys' =>
        [
            'source' => 'iana',
        ],
    'application/pgp-signature' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'asc',
                    1 => 'sig',
                ],
        ],
    'application/pics-rules' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'prf',
                ],
        ],
    'application/pidf+xml' =>
        [
            'source' => 'iana',
        ],
    'application/pidf-diff+xml' =>
        [
            'source' => 'iana',
        ],
    'application/pkcs10' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'p10',
                ],
        ],
    'application/pkcs12' =>
        [
            'source' => 'iana',
        ],
    'application/pkcs7-mime' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'p7m',
                    1 => 'p7c',
                ],
        ],
    'application/pkcs7-signature' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'p7s',
                ],
        ],
    'application/pkcs8' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'p8',
                ],
        ],
    'application/pkix-attr-cert' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ac',
                ],
        ],
    'application/pkix-cert' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cer',
                ],
        ],
    'application/pkix-crl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'crl',
                ],
        ],
    'application/pkix-pkipath' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pkipath',
                ],
        ],
    'application/pkixcmp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pki',
                ],
        ],
    'application/pls+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pls',
                ],
        ],
    'application/poc-settings+xml' =>
        [
            'source' => 'iana',
        ],
    'application/postscript' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'ai',
                    1 => 'eps',
                    2 => 'ps',
                ],
        ],
    'application/ppsp-tracker+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/problem+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/problem+xml' =>
        [
            'source' => 'iana',
        ],
    'application/provenance+xml' =>
        [
            'source' => 'iana',
        ],
    'application/prs.alvestrand.titrax-sheet' =>
        [
            'source' => 'iana',
        ],
    'application/prs.cww' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cww',
                ],
        ],
    'application/prs.hpub+zip' =>
        [
            'source' => 'iana',
        ],
    'application/prs.nprend' =>
        [
            'source' => 'iana',
        ],
    'application/prs.plucker' =>
        [
            'source' => 'iana',
        ],
    'application/prs.rdf-xml-crypt' =>
        [
            'source' => 'iana',
        ],
    'application/prs.xsf+xml' =>
        [
            'source' => 'iana',
        ],
    'application/pskc+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pskcxml',
                ],
        ],
    'application/qsig' =>
        [
            'source' => 'iana',
        ],
    'application/raptorfec' =>
        [
            'source' => 'iana',
        ],
    'application/rdap+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/rdf+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'rdf',
                ],
        ],
    'application/reginfo+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rif',
                ],
        ],
    'application/relax-ng-compact-syntax' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rnc',
                ],
        ],
    'application/remote-printing' =>
        [
            'source' => 'iana',
        ],
    'application/reputon+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/resource-lists+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rl',
                ],
        ],
    'application/resource-lists-diff+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rld',
                ],
        ],
    'application/rfc+xml' =>
        [
            'source' => 'iana',
        ],
    'application/riscos' =>
        [
            'source' => 'iana',
        ],
    'application/rlmi+xml' =>
        [
            'source' => 'iana',
        ],
    'application/rls-services+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rs',
                ],
        ],
    'application/rpki-ghostbusters' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gbr',
                ],
        ],
    'application/rpki-manifest' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mft',
                ],
        ],
    'application/rpki-publication' =>
        [
            'source' => 'iana',
        ],
    'application/rpki-roa' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'roa',
                ],
        ],
    'application/rpki-updown' =>
        [
            'source' => 'iana',
        ],
    'application/rsd+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'rsd',
                ],
        ],
    'application/rss+xml' =>
        [
            'source' => 'apache',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'rss',
                ],
        ],
    'application/rtf' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'rtf',
                ],
        ],
    'application/rtploopback' =>
        [
            'source' => 'iana',
        ],
    'application/rtx' =>
        [
            'source' => 'iana',
        ],
    'application/samlassertion+xml' =>
        [
            'source' => 'iana',
        ],
    'application/samlmetadata+xml' =>
        [
            'source' => 'iana',
        ],
    'application/sbml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sbml',
                ],
        ],
    'application/scaip+xml' =>
        [
            'source' => 'iana',
        ],
    'application/scim+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/scvp-cv-request' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'scq',
                ],
        ],
    'application/scvp-cv-response' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'scs',
                ],
        ],
    'application/scvp-vp-request' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'spq',
                ],
        ],
    'application/scvp-vp-response' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'spp',
                ],
        ],
    'application/sdp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sdp',
                ],
        ],
    'application/sep+xml' =>
        [
            'source' => 'iana',
        ],
    'application/sep-exi' =>
        [
            'source' => 'iana',
        ],
    'application/session-info' =>
        [
            'source' => 'iana',
        ],
    'application/set-payment' =>
        [
            'source' => 'iana',
        ],
    'application/set-payment-initiation' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'setpay',
                ],
        ],
    'application/set-registration' =>
        [
            'source' => 'iana',
        ],
    'application/set-registration-initiation' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'setreg',
                ],
        ],
    'application/sgml' =>
        [
            'source' => 'iana',
        ],
    'application/sgml-open-catalog' =>
        [
            'source' => 'iana',
        ],
    'application/shf+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'shf',
                ],
        ],
    'application/sieve' =>
        [
            'source' => 'iana',
        ],
    'application/simple-filter+xml' =>
        [
            'source' => 'iana',
        ],
    'application/simple-message-summary' =>
        [
            'source' => 'iana',
        ],
    'application/simplesymbolcontainer' =>
        [
            'source' => 'iana',
        ],
    'application/slate' =>
        [
            'source' => 'iana',
        ],
    'application/smil' =>
        [
            'source' => 'iana',
        ],
    'application/smil+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'smi',
                    1 => 'smil',
                ],
        ],
    'application/smpte336m' =>
        [
            'source' => 'iana',
        ],
    'application/soap+fastinfoset' =>
        [
            'source' => 'iana',
        ],
    'application/soap+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/sparql-query' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rq',
                ],
        ],
    'application/sparql-results+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'srx',
                ],
        ],
    'application/spirits-event+xml' =>
        [
            'source' => 'iana',
        ],
    'application/sql' =>
        [
            'source' => 'iana',
        ],
    'application/srgs' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gram',
                ],
        ],
    'application/srgs+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'grxml',
                ],
        ],
    'application/sru+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sru',
                ],
        ],
    'application/ssdl+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ssdl',
                ],
        ],
    'application/ssml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ssml',
                ],
        ],
    'application/tamp-apex-update' =>
        [
            'source' => 'iana',
        ],
    'application/tamp-apex-update-confirm' =>
        [
            'source' => 'iana',
        ],
    'application/tamp-community-update' =>
        [
            'source' => 'iana',
        ],
    'application/tamp-community-update-confirm' =>
        [
            'source' => 'iana',
        ],
    'application/tamp-error' =>
        [
            'source' => 'iana',
        ],
    'application/tamp-sequence-adjust' =>
        [
            'source' => 'iana',
        ],
    'application/tamp-sequence-adjust-confirm' =>
        [
            'source' => 'iana',
        ],
    'application/tamp-status-query' =>
        [
            'source' => 'iana',
        ],
    'application/tamp-status-response' =>
        [
            'source' => 'iana',
        ],
    'application/tamp-update' =>
        [
            'source' => 'iana',
        ],
    'application/tamp-update-confirm' =>
        [
            'source' => 'iana',
        ],
    'application/tar' =>
        [
            'compressible' => true,
        ],
    'application/tei+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'tei',
                    1 => 'teicorpus',
                ],
        ],
    'application/thraud+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'tfi',
                ],
        ],
    'application/timestamp-query' =>
        [
            'source' => 'iana',
        ],
    'application/timestamp-reply' =>
        [
            'source' => 'iana',
        ],
    'application/timestamped-data' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'tsd',
                ],
        ],
    'application/trig' =>
        [
            'source' => 'iana',
        ],
    'application/ttml+xml' =>
        [
            'source' => 'iana',
        ],
    'application/tve-trigger' =>
        [
            'source' => 'iana',
        ],
    'application/ulpfec' =>
        [
            'source' => 'iana',
        ],
    'application/urc-grpsheet+xml' =>
        [
            'source' => 'iana',
        ],
    'application/urc-ressheet+xml' =>
        [
            'source' => 'iana',
        ],
    'application/urc-targetdesc+xml' =>
        [
            'source' => 'iana',
        ],
    'application/urc-uisocketdesc+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vcard+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vcard+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vemmi' =>
        [
            'source' => 'iana',
        ],
    'application/vividence.scriptfile' =>
        [
            'source' => 'apache',
        ],
    'application/vnd.1000minds.decision-model+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp-prose+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp-prose-pc3ch+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp.access-transfer-events+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp.bsf+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp.mid-call+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp.pic-bw-large' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'plb',
                ],
        ],
    'application/vnd.3gpp.pic-bw-small' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'psb',
                ],
        ],
    'application/vnd.3gpp.pic-bw-var' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pvb',
                ],
        ],
    'application/vnd.3gpp.sms' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp.sms+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp.srvcc-ext+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp.srvcc-info+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp.state-and-event-info+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp.ussd+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp2.bcmcsinfo+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp2.sms' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3gpp2.tcap' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'tcap',
                ],
        ],
    'application/vnd.3lightssoftware.imagescal' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.3m.post-it-notes' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pwn',
                ],
        ],
    'application/vnd.accpac.simply.aso' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'aso',
                ],
        ],
    'application/vnd.accpac.simply.imp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'imp',
                ],
        ],
    'application/vnd.acucobol' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'acu',
                ],
        ],
    'application/vnd.acucorp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'atc',
                    1 => 'acutc',
                ],
        ],
    'application/vnd.adobe.air-application-installer-package+zip' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'air',
                ],
        ],
    'application/vnd.adobe.flash.movie' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.adobe.formscentral.fcdt' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fcdt',
                ],
        ],
    'application/vnd.adobe.fxp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fxp',
                    1 => 'fxpl',
                ],
        ],
    'application/vnd.adobe.partial-upload' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.adobe.xdp+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xdp',
                ],
        ],
    'application/vnd.adobe.xfdf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xfdf',
                ],
        ],
    'application/vnd.aether.imp' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ah-barcode' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ahead.space' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ahead',
                ],
        ],
    'application/vnd.airzip.filesecure.azf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'azf',
                ],
        ],
    'application/vnd.airzip.filesecure.azs' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'azs',
                ],
        ],
    'application/vnd.amazon.ebook' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'azw',
                ],
        ],
    'application/vnd.amazon.mobi8-ebook' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.americandynamics.acc' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'acc',
                ],
        ],
    'application/vnd.amiga.ami' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ami',
                ],
        ],
    'application/vnd.amundsen.maze+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.android.package-archive' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'apk',
                ],
        ],
    'application/vnd.anki' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.anser-web-certificate-issue-initiation' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cii',
                ],
        ],
    'application/vnd.anser-web-funds-transfer-initiation' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'fti',
                ],
        ],
    'application/vnd.antix.game-component' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'atx',
                ],
        ],
    'application/vnd.apache.thrift.binary' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.apache.thrift.compact' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.apache.thrift.json' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.api+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.apothekende.reservation+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.apple.installer+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mpkg',
                ],
        ],
    'application/vnd.apple.mpegurl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'm3u8',
                ],
        ],
    'application/vnd.apple.pkpass' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'pkpass',
                ],
        ],
    'application/vnd.arastra.swi' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.aristanetworks.swi' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'swi',
                ],
        ],
    'application/vnd.artsquare' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.astraea-software.iota' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'iota',
                ],
        ],
    'application/vnd.audiograph' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'aep',
                ],
        ],
    'application/vnd.autopackage' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.avistar+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.balsamiq.bmml+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.balsamiq.bmpr' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.bekitzur-stech+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.bint.med-content' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.biopax.rdf+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.blink-idb-value-wrapper' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.blueice.multipass' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mpm',
                ],
        ],
    'application/vnd.bluetooth.ep.oob' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.bluetooth.le.oob' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.bmi' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'bmi',
                ],
        ],
    'application/vnd.businessobjects' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rep',
                ],
        ],
    'application/vnd.cab-jscript' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.canon-cpdl' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.canon-lips' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.capasystems-pg+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.cendio.thinlinc.clientconf' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.century-systems.tcp_stream' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.chemdraw+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cdxml',
                ],
        ],
    'application/vnd.chess-pgn' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.chipnuts.karaoke-mmd' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mmd',
                ],
        ],
    'application/vnd.cinderella' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cdy',
                ],
        ],
    'application/vnd.cirpack.isdn-ext' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.citationstyles.style+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.claymore' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cla',
                ],
        ],
    'application/vnd.cloanto.rp9' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rp9',
                ],
        ],
    'application/vnd.clonk.c4group' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'c4g',
                    1 => 'c4d',
                    2 => 'c4f',
                    3 => 'c4p',
                    4 => 'c4u',
                ],
        ],
    'application/vnd.cluetrust.cartomobile-config' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'c11amc',
                ],
        ],
    'application/vnd.cluetrust.cartomobile-config-pkg' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'c11amz',
                ],
        ],
    'application/vnd.coffeescript' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.collection+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.collection.doc+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.collection.next+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.comicbook+zip' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.commerce-battelle' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.commonspace' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'csp',
                ],
        ],
    'application/vnd.contact.cmsg' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cdbcmsg',
                ],
        ],
    'application/vnd.coreos.ignition+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.cosmocaller' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cmc',
                ],
        ],
    'application/vnd.crick.clicker' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'clkx',
                ],
        ],
    'application/vnd.crick.clicker.keyboard' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'clkk',
                ],
        ],
    'application/vnd.crick.clicker.palette' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'clkp',
                ],
        ],
    'application/vnd.crick.clicker.template' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'clkt',
                ],
        ],
    'application/vnd.crick.clicker.wordbank' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'clkw',
                ],
        ],
    'application/vnd.criticaltools.wbs+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wbs',
                ],
        ],
    'application/vnd.ctc-posml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pml',
                ],
        ],
    'application/vnd.ctct.ws+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.cups-pdf' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.cups-postscript' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.cups-ppd' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ppd',
                ],
        ],
    'application/vnd.cups-raster' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.cups-raw' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.curl' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.curl.car' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'car',
                ],
        ],
    'application/vnd.curl.pcurl' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pcurl',
                ],
        ],
    'application/vnd.cyan.dean.root+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.cybank' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.d2l.coursepackage1p0+zip' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dart' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'dart',
                ],
        ],
    'application/vnd.data-vision.rdz' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rdz',
                ],
        ],
    'application/vnd.datapackage+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.dataresource+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.debian.binary-package' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dece.data' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'uvf',
                    1 => 'uvvf',
                    2 => 'uvd',
                    3 => 'uvvd',
                ],
        ],
    'application/vnd.dece.ttml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'uvt',
                    1 => 'uvvt',
                ],
        ],
    'application/vnd.dece.unspecified' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'uvx',
                    1 => 'uvvx',
                ],
        ],
    'application/vnd.dece.zip' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'uvz',
                    1 => 'uvvz',
                ],
        ],
    'application/vnd.denovo.fcselayout-link' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fe_launch',
                ],
        ],
    'application/vnd.desmume-movie' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.desmume.movie' =>
        [
            'source' => 'apache',
        ],
    'application/vnd.dir-bi.plate-dl-nosuffix' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dm.delegation+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dna' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dna',
                ],
        ],
    'application/vnd.document+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.dolby.mlp' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mlp',
                ],
        ],
    'application/vnd.dolby.mobile.1' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dolby.mobile.2' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.doremir.scorecloud-binary-document' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dpgraph' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dpg',
                ],
        ],
    'application/vnd.dreamfactory' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dfac',
                ],
        ],
    'application/vnd.drive+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.ds-keypoint' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'kpxx',
                ],
        ],
    'application/vnd.dtg.local' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dtg.local.flash' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dtg.local.html' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.ait' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ait',
                ],
        ],
    'application/vnd.dvb.dvbj' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.esgcontainer' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.ipdcdftnotifaccess' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.ipdcesgaccess' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.ipdcesgaccess2' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.ipdcesgpdd' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.ipdcroaming' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.iptv.alfec-base' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.iptv.alfec-enhancement' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.notif-aggregate-root+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.notif-container+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.notif-generic+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.notif-ia-msglist+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.notif-ia-registration-request+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.notif-ia-registration-response+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.notif-init+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.pfr' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dvb.service' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'svc',
                ],
        ],
    'application/vnd.dxr' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.dynageo' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'geo',
                ],
        ],
    'application/vnd.dzr' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.easykaraoke.cdgdownload' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ecdis-update' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ecowin.chart' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mag',
                ],
        ],
    'application/vnd.ecowin.filerequest' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ecowin.fileupdate' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ecowin.series' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ecowin.seriesrequest' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ecowin.seriesupdate' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.efi.img' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.efi.iso' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.emclient.accessrequest+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.enliven' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'nml',
                ],
        ],
    'application/vnd.enphase.envoy' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.eprints.data+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.epson.esf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'esf',
                ],
        ],
    'application/vnd.epson.msf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'msf',
                ],
        ],
    'application/vnd.epson.quickanime' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'qam',
                ],
        ],
    'application/vnd.epson.salt' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'slt',
                ],
        ],
    'application/vnd.epson.ssf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ssf',
                ],
        ],
    'application/vnd.ericsson.quickcall' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.espass-espass+zip' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.eszigno3+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'es3',
                    1 => 'et3',
                ],
        ],
    'application/vnd.etsi.aoc+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.asic-e+zip' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.asic-s+zip' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.cug+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.iptvcommand+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.iptvdiscovery+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.iptvprofile+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.iptvsad-bc+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.iptvsad-cod+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.iptvsad-npvr+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.iptvservice+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.iptvsync+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.iptvueprofile+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.mcid+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.mheg5' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.overload-control-policy-dataset+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.pstn+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.sci+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.simservs+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.timestamp-token' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.tsl+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.etsi.tsl.der' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.eudora.data' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.evolv.ecig.theme' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ezpix-album' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ez2',
                ],
        ],
    'application/vnd.ezpix-package' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ez3',
                ],
        ],
    'application/vnd.f-secure.mobile' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.fastcopy-disk-image' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.fdf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fdf',
                ],
        ],
    'application/vnd.fdsn.mseed' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mseed',
                ],
        ],
    'application/vnd.fdsn.seed' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'seed',
                    1 => 'dataless',
                ],
        ],
    'application/vnd.ffsns' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.filmit.zfc' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.fints' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.firemonkeys.cloudcell' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.flographit' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gph',
                ],
        ],
    'application/vnd.fluxtime.clip' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ftc',
                ],
        ],
    'application/vnd.font-fontforge-sfd' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.framemaker' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fm',
                    1 => 'frame',
                    2 => 'maker',
                    3 => 'book',
                ],
        ],
    'application/vnd.frogans.fnc' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fnc',
                ],
        ],
    'application/vnd.frogans.ltf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ltf',
                ],
        ],
    'application/vnd.fsc.weblaunch' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fsc',
                ],
        ],
    'application/vnd.fujitsu.oasys' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'oas',
                ],
        ],
    'application/vnd.fujitsu.oasys2' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'oa2',
                ],
        ],
    'application/vnd.fujitsu.oasys3' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'oa3',
                ],
        ],
    'application/vnd.fujitsu.oasysgp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fg5',
                ],
        ],
    'application/vnd.fujitsu.oasysprs' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'bh2',
                ],
        ],
    'application/vnd.fujixerox.art-ex' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.fujixerox.art4' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.fujixerox.ddd' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ddd',
                ],
        ],
    'application/vnd.fujixerox.docuworks' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xdw',
                ],
        ],
    'application/vnd.fujixerox.docuworks.binder' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xbd',
                ],
        ],
    'application/vnd.fujixerox.docuworks.container' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.fujixerox.hbpl' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.fut-misnet' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.fuzzysheet' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fzs',
                ],
        ],
    'application/vnd.genomatix.tuxedo' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'txd',
                ],
        ],
    'application/vnd.geo+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.geocube+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.geogebra.file' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ggb',
                ],
        ],
    'application/vnd.geogebra.tool' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ggt',
                ],
        ],
    'application/vnd.geometry-explorer' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gex',
                    1 => 'gre',
                ],
        ],
    'application/vnd.geonext' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gxt',
                ],
        ],
    'application/vnd.geoplan' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'g2w',
                ],
        ],
    'application/vnd.geospace' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'g3w',
                ],
        ],
    'application/vnd.gerber' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.globalplatform.card-content-mgt' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.globalplatform.card-content-mgt-response' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.gmx' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gmx',
                ],
        ],
    'application/vnd.google-apps.document' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'gdoc',
                ],
        ],
    'application/vnd.google-apps.presentation' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'gslides',
                ],
        ],
    'application/vnd.google-apps.spreadsheet' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'gsheet',
                ],
        ],
    'application/vnd.google-earth.kml+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'kml',
                ],
        ],
    'application/vnd.google-earth.kmz' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'kmz',
                ],
        ],
    'application/vnd.gov.sk.e-form+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.gov.sk.e-form+zip' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.gov.sk.xmldatacontainer+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.grafeq' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gqf',
                    1 => 'gqs',
                ],
        ],
    'application/vnd.gridmp' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.groove-account' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gac',
                ],
        ],
    'application/vnd.groove-help' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ghf',
                ],
        ],
    'application/vnd.groove-identity-message' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gim',
                ],
        ],
    'application/vnd.groove-injector' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'grv',
                ],
        ],
    'application/vnd.groove-tool-message' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gtm',
                ],
        ],
    'application/vnd.groove-tool-template' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'tpl',
                ],
        ],
    'application/vnd.groove-vcard' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'vcg',
                ],
        ],
    'application/vnd.hal+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.hal+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'hal',
                ],
        ],
    'application/vnd.handheld-entertainment+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'zmm',
                ],
        ],
    'application/vnd.hbci' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'hbci',
                ],
        ],
    'application/vnd.hc+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.hcl-bireports' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.hdt' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.heroku+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.hhe.lesson-player' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'les',
                ],
        ],
    'application/vnd.hp-hpgl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'hpgl',
                ],
        ],
    'application/vnd.hp-hpid' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'hpid',
                ],
        ],
    'application/vnd.hp-hps' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'hps',
                ],
        ],
    'application/vnd.hp-jlyt' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'jlt',
                ],
        ],
    'application/vnd.hp-pcl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pcl',
                ],
        ],
    'application/vnd.hp-pclxl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pclxl',
                ],
        ],
    'application/vnd.httphone' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.hydrostatix.sof-data' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sfd-hdstx',
                ],
        ],
    'application/vnd.hyper-item+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.hyperdrive+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.hzn-3d-crossword' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ibm.afplinedata' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ibm.electronic-media' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ibm.minipay' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mpy',
                ],
        ],
    'application/vnd.ibm.modcap' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'afp',
                    1 => 'listafp',
                    2 => 'list3820',
                ],
        ],
    'application/vnd.ibm.rights-management' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'irm',
                ],
        ],
    'application/vnd.ibm.secure-container' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sc',
                ],
        ],
    'application/vnd.iccprofile' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'icc',
                    1 => 'icm',
                ],
        ],
    'application/vnd.ieee.1905' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.igloader' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'igl',
                ],
        ],
    'application/vnd.imagemeter.folder+zip' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.imagemeter.image+zip' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.immervision-ivp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ivp',
                ],
        ],
    'application/vnd.immervision-ivu' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ivu',
                ],
        ],
    'application/vnd.ims.imsccv1p1' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ims.imsccv1p2' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ims.imsccv1p3' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ims.lis.v2.result+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.ims.lti.v2.toolconsumerprofile+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.ims.lti.v2.toolproxy+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.ims.lti.v2.toolproxy.id+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.ims.lti.v2.toolsettings+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.ims.lti.v2.toolsettings.simple+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.informedcontrol.rms+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.informix-visionary' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.infotech.project' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.infotech.project+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.innopath.wamp.notification' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.insors.igm' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'igm',
                ],
        ],
    'application/vnd.intercon.formnet' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xpw',
                    1 => 'xpx',
                ],
        ],
    'application/vnd.intergeo' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'i2g',
                ],
        ],
    'application/vnd.intertrust.digibox' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.intertrust.nncp' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.intu.qbo' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'qbo',
                ],
        ],
    'application/vnd.intu.qfx' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'qfx',
                ],
        ],
    'application/vnd.iptc.g2.catalogitem+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.iptc.g2.conceptitem+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.iptc.g2.knowledgeitem+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.iptc.g2.newsitem+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.iptc.g2.newsmessage+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.iptc.g2.packageitem+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.iptc.g2.planningitem+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ipunplugged.rcprofile' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rcprofile',
                ],
        ],
    'application/vnd.irepository.package+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'irp',
                ],
        ],
    'application/vnd.is-xpr' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xpr',
                ],
        ],
    'application/vnd.isac.fcs' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fcs',
                ],
        ],
    'application/vnd.jam' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'jam',
                ],
        ],
    'application/vnd.japannet-directory-service' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.japannet-jpnstore-wakeup' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.japannet-payment-wakeup' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.japannet-registration' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.japannet-registration-wakeup' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.japannet-setstore-wakeup' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.japannet-verification' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.japannet-verification-wakeup' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.jcp.javame.midlet-rms' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rms',
                ],
        ],
    'application/vnd.jisp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'jisp',
                ],
        ],
    'application/vnd.joost.joda-archive' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'joda',
                ],
        ],
    'application/vnd.jsk.isdn-ngn' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.kahootz' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ktz',
                    1 => 'ktr',
                ],
        ],
    'application/vnd.kde.karbon' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'karbon',
                ],
        ],
    'application/vnd.kde.kchart' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'chrt',
                ],
        ],
    'application/vnd.kde.kformula' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'kfo',
                ],
        ],
    'application/vnd.kde.kivio' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'flw',
                ],
        ],
    'application/vnd.kde.kontour' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'kon',
                ],
        ],
    'application/vnd.kde.kpresenter' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'kpr',
                    1 => 'kpt',
                ],
        ],
    'application/vnd.kde.kspread' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ksp',
                ],
        ],
    'application/vnd.kde.kword' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'kwd',
                    1 => 'kwt',
                ],
        ],
    'application/vnd.kenameaapp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'htke',
                ],
        ],
    'application/vnd.kidspiration' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'kia',
                ],
        ],
    'application/vnd.kinar' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'kne',
                    1 => 'knp',
                ],
        ],
    'application/vnd.koan' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'skp',
                    1 => 'skd',
                    2 => 'skt',
                    3 => 'skm',
                ],
        ],
    'application/vnd.kodak-descriptor' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sse',
                ],
        ],
    'application/vnd.las.las+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.las.las+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'lasxml',
                ],
        ],
    'application/vnd.liberty-request+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.llamagraphics.life-balance.desktop' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'lbd',
                ],
        ],
    'application/vnd.llamagraphics.life-balance.exchange+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'lbe',
                ],
        ],
    'application/vnd.lotus-1-2-3' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => '123',
                ],
        ],
    'application/vnd.lotus-approach' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'apr',
                ],
        ],
    'application/vnd.lotus-freelance' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pre',
                ],
        ],
    'application/vnd.lotus-notes' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'nsf',
                ],
        ],
    'application/vnd.lotus-organizer' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'org',
                ],
        ],
    'application/vnd.lotus-screencam' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'scm',
                ],
        ],
    'application/vnd.lotus-wordpro' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'lwp',
                ],
        ],
    'application/vnd.macports.portpkg' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'portpkg',
                ],
        ],
    'application/vnd.mapbox-vector-tile' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.marlin.drm.actiontoken+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.marlin.drm.conftoken+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.marlin.drm.license+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.marlin.drm.mdcf' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.mason+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.maxmind.maxmind-db' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.mcd' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mcd',
                ],
        ],
    'application/vnd.medcalcdata' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mc1',
                ],
        ],
    'application/vnd.mediastation.cdkey' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cdkey',
                ],
        ],
    'application/vnd.meridian-slingshot' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.mfer' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mwf',
                ],
        ],
    'application/vnd.mfmp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mfm',
                ],
        ],
    'application/vnd.micro+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.micrografx.flo' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'flo',
                ],
        ],
    'application/vnd.micrografx.igx' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'igx',
                ],
        ],
    'application/vnd.microsoft.portable-executable' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.microsoft.windows.thumbnail-cache' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.miele+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.mif' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mif',
                ],
        ],
    'application/vnd.minisoft-hp3000-save' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.mitsubishi.misty-guard.trustweb' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.mobius.daf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'daf',
                ],
        ],
    'application/vnd.mobius.dis' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dis',
                ],
        ],
    'application/vnd.mobius.mbk' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mbk',
                ],
        ],
    'application/vnd.mobius.mqy' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mqy',
                ],
        ],
    'application/vnd.mobius.msl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'msl',
                ],
        ],
    'application/vnd.mobius.plc' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'plc',
                ],
        ],
    'application/vnd.mobius.txf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'txf',
                ],
        ],
    'application/vnd.mophun.application' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mpn',
                ],
        ],
    'application/vnd.mophun.certificate' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mpc',
                ],
        ],
    'application/vnd.motorola.flexsuite' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.motorola.flexsuite.adsi' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.motorola.flexsuite.fis' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.motorola.flexsuite.gotap' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.motorola.flexsuite.kmr' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.motorola.flexsuite.ttc' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.motorola.flexsuite.wem' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.motorola.iprm' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.mozilla.xul+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'xul',
                ],
        ],
    'application/vnd.ms-3mfdocument' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-artgalry' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cil',
                ],
        ],
    'application/vnd.ms-asf' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-cab-compressed' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cab',
                ],
        ],
    'application/vnd.ms-color.iccprofile' =>
        [
            'source' => 'apache',
        ],
    'application/vnd.ms-excel' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'xls',
                    1 => 'xlm',
                    2 => 'xla',
                    3 => 'xlc',
                    4 => 'xlt',
                    5 => 'xlw',
                ],
        ],
    'application/vnd.ms-excel.addin.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xlam',
                ],
        ],
    'application/vnd.ms-excel.sheet.binary.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xlsb',
                ],
        ],
    'application/vnd.ms-excel.sheet.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xlsm',
                ],
        ],
    'application/vnd.ms-excel.template.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xltm',
                ],
        ],
    'application/vnd.ms-fontobject' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'eot',
                ],
        ],
    'application/vnd.ms-htmlhelp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'chm',
                ],
        ],
    'application/vnd.ms-ims' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ims',
                ],
        ],
    'application/vnd.ms-lrm' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'lrm',
                ],
        ],
    'application/vnd.ms-office.activex+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-officetheme' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'thmx',
                ],
        ],
    'application/vnd.ms-opentype' =>
        [
            'source' => 'apache',
            'compressible' => true,
        ],
    'application/vnd.ms-package.obfuscated-opentype' =>
        [
            'source' => 'apache',
        ],
    'application/vnd.ms-pki.seccat' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cat',
                ],
        ],
    'application/vnd.ms-pki.stl' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'stl',
                ],
        ],
    'application/vnd.ms-playready.initiator+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-powerpoint' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'ppt',
                    1 => 'pps',
                    2 => 'pot',
                ],
        ],
    'application/vnd.ms-powerpoint.addin.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ppam',
                ],
        ],
    'application/vnd.ms-powerpoint.presentation.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pptm',
                ],
        ],
    'application/vnd.ms-powerpoint.slide.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sldm',
                ],
        ],
    'application/vnd.ms-powerpoint.slideshow.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ppsm',
                ],
        ],
    'application/vnd.ms-powerpoint.template.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'potm',
                ],
        ],
    'application/vnd.ms-printdevicecapabilities+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-printing.printticket+xml' =>
        [
            'source' => 'apache',
        ],
    'application/vnd.ms-printschematicket+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-project' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mpp',
                    1 => 'mpt',
                ],
        ],
    'application/vnd.ms-tnef' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-windows.devicepairing' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-windows.nwprinting.oob' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-windows.printerpairing' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-windows.wsd.oob' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-wmdrm.lic-chlg-req' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-wmdrm.lic-resp' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-wmdrm.meter-chlg-req' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-wmdrm.meter-resp' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ms-word.document.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'docm',
                ],
        ],
    'application/vnd.ms-word.template.macroenabled.12' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dotm',
                ],
        ],
    'application/vnd.ms-works' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wps',
                    1 => 'wks',
                    2 => 'wcm',
                    3 => 'wdb',
                ],
        ],
    'application/vnd.ms-wpl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wpl',
                ],
        ],
    'application/vnd.ms-xpsdocument' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'xps',
                ],
        ],
    'application/vnd.msa-disk-image' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.mseq' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mseq',
                ],
        ],
    'application/vnd.msign' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.multiad.creator' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.multiad.creator.cif' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.music-niff' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.musician' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mus',
                ],
        ],
    'application/vnd.muvee.style' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'msty',
                ],
        ],
    'application/vnd.mynfc' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'taglet',
                ],
        ],
    'application/vnd.ncd.control' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ncd.reference' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nearst.inv+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.nervana' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.netfpx' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.neurolanguage.nlu' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'nlu',
                ],
        ],
    'application/vnd.nintendo.nitro.rom' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nintendo.snes.rom' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nitf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ntf',
                    1 => 'nitf',
                ],
        ],
    'application/vnd.noblenet-directory' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'nnd',
                ],
        ],
    'application/vnd.noblenet-sealer' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'nns',
                ],
        ],
    'application/vnd.noblenet-web' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'nnw',
                ],
        ],
    'application/vnd.nokia.catalogs' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.conml+wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.conml+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.iptv.config+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.isds-radio-presets' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.landmark+wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.landmark+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.landmarkcollection+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.n-gage.ac+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.n-gage.data' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ngdat',
                ],
        ],
    'application/vnd.nokia.n-gage.symbian.install' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'n-gage',
                ],
        ],
    'application/vnd.nokia.ncd' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.pcd+wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.pcd+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.nokia.radio-preset' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rpst',
                ],
        ],
    'application/vnd.nokia.radio-presets' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rpss',
                ],
        ],
    'application/vnd.novadigm.edm' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'edm',
                ],
        ],
    'application/vnd.novadigm.edx' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'edx',
                ],
        ],
    'application/vnd.novadigm.ext' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ext',
                ],
        ],
    'application/vnd.ntt-local.content-share' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ntt-local.file-transfer' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ntt-local.ogw_remote-access' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ntt-local.sip-ta_remote' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ntt-local.sip-ta_tcp_stream' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oasis.opendocument.chart' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'odc',
                ],
        ],
    'application/vnd.oasis.opendocument.chart-template' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'otc',
                ],
        ],
    'application/vnd.oasis.opendocument.database' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'odb',
                ],
        ],
    'application/vnd.oasis.opendocument.formula' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'odf',
                ],
        ],
    'application/vnd.oasis.opendocument.formula-template' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'odft',
                ],
        ],
    'application/vnd.oasis.opendocument.graphics' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'odg',
                ],
        ],
    'application/vnd.oasis.opendocument.graphics-template' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'otg',
                ],
        ],
    'application/vnd.oasis.opendocument.image' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'odi',
                ],
        ],
    'application/vnd.oasis.opendocument.image-template' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'oti',
                ],
        ],
    'application/vnd.oasis.opendocument.presentation' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'odp',
                ],
        ],
    'application/vnd.oasis.opendocument.presentation-template' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'otp',
                ],
        ],
    'application/vnd.oasis.opendocument.spreadsheet' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'ods',
                ],
        ],
    'application/vnd.oasis.opendocument.spreadsheet-template' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ots',
                ],
        ],
    'application/vnd.oasis.opendocument.text' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'odt',
                ],
        ],
    'application/vnd.oasis.opendocument.text-master' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'odm',
                ],
        ],
    'application/vnd.oasis.opendocument.text-template' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ott',
                ],
        ],
    'application/vnd.oasis.opendocument.text-web' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'oth',
                ],
        ],
    'application/vnd.obn' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ocf+cbor' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oftn.l10n+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.oipf.contentaccessdownload+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oipf.contentaccessstreaming+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oipf.cspg-hexbinary' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oipf.dae.svg+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oipf.dae.xhtml+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oipf.mippvcontrolmessage+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oipf.pae.gem' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oipf.spdiscovery+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oipf.spdlist+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oipf.ueprofile+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oipf.userprofile+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.olpc-sugar' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xo',
                ],
        ],
    'application/vnd.oma-scws-config' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma-scws-http-request' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma-scws-http-response' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.associated-procedure-parameter+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.drm-trigger+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.imd+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.ltkm' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.notification+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.provisioningtrigger' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.sgboot' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.sgdd+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.sgdu' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.simple-symbol-container' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.smartcard-trigger+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.sprov+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.bcast.stkm' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.cab-address-book+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.cab-feature-handler+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.cab-pcc+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.cab-subs-invite+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.cab-user-prefs+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.dcd' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.dcdc' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.dd2+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dd2',
                ],
        ],
    'application/vnd.oma.drm.risd+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.group-usage-list+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.lwm2m+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.oma.lwm2m+tlv' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.pal+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.poc.detailed-progress-report+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.poc.final-report+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.poc.groups+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.poc.invocation-descriptor+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.poc.optimized-progress-report+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.push' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.scidm.messages+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oma.xcap-directory+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.omads-email+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.omads-file+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.omads-folder+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.omaloc-supl-init' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.onepager' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.onepagertamp' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.onepagertamx' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.onepagertat' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.onepagertatp' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.onepagertatx' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openblox.game+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openblox.game-binary' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openeye.oeb' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openofficeorg.extension' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'oxt',
                ],
        ],
    'application/vnd.openstreetmap.data+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.custom-properties+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.customxmlproperties+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.drawing+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.drawingml.chart+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.drawingml.chartshapes+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.drawingml.diagramcolors+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.drawingml.diagramdata+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.drawingml.diagramlayout+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.drawingml.diagramstyle+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.extended-properties+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml-template' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.commentauthors+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.comments+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.handoutmaster+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.notesmaster+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.notesslide+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.presentation' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'pptx',
                ],
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.presentation.main+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.presprops+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.slide' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sldx',
                ],
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.slide+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.slidelayout+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.slidemaster+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.slideshow' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ppsx',
                ],
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.slideshow.main+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.slideupdateinfo+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.tablestyles+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.tags+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.template' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'potx',
                ],
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.template.main+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.presentationml.viewprops+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml-template' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.calcchain+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.chartsheet+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.comments+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.connections+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.dialogsheet+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.externallink+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.pivotcachedefinition+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.pivotcacherecords+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.pivottable+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.querytable+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.revisionheaders+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.revisionlog+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sharedstrings+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'xlsx',
                ],
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheetmetadata+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.table+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.tablesinglecells+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.template' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xltx',
                ],
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.template.main+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.usernames+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.volatiledependencies+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.theme+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.themeoverride+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.vmldrawing' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml-template' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.comments+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'docx',
                ],
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document.glossary+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.endnotes+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.fonttable+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.footer+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.footnotes+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.numbering+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.settings+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.template' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'dotx',
                ],
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.template.main+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-officedocument.wordprocessingml.websettings+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-package.core-properties+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-package.digital-signature-xmlsignature+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.openxmlformats-package.relationships+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oracle.resource+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.orange.indata' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.osa.netdeploy' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.osgeo.mapguide.package' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mgp',
                ],
        ],
    'application/vnd.osgi.bundle' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.osgi.dp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dp',
                ],
        ],
    'application/vnd.osgi.subsystem' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'esa',
                ],
        ],
    'application/vnd.otps.ct-kip+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.oxli.countgraph' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.pagerduty+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.palm' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pdb',
                    1 => 'pqa',
                    2 => 'oprc',
                ],
        ],
    'application/vnd.panoply' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.paos+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.paos.xml' =>
        [
            'source' => 'apache',
        ],
    'application/vnd.pawaafile' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'paw',
                ],
        ],
    'application/vnd.pcos' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.pg.format' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'str',
                ],
        ],
    'application/vnd.pg.osasli' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ei6',
                ],
        ],
    'application/vnd.piaccess.application-licence' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.picsel' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'efif',
                ],
        ],
    'application/vnd.pmi.widget' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wg',
                ],
        ],
    'application/vnd.poc.group-advertisement+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.pocketlearn' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'plf',
                ],
        ],
    'application/vnd.powerbuilder6' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pbd',
                ],
        ],
    'application/vnd.powerbuilder6-s' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.powerbuilder7' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.powerbuilder7-s' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.powerbuilder75' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.powerbuilder75-s' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.preminet' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.previewsystems.box' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'box',
                ],
        ],
    'application/vnd.proteus.magazine' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mgz',
                ],
        ],
    'application/vnd.publishare-delta-tree' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'qps',
                ],
        ],
    'application/vnd.pvi.ptid1' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ptid',
                ],
        ],
    'application/vnd.pwg-multiplexed' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.pwg-xhtml-print+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.qualcomm.brew-app-res' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.quarantainenet' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.quark.quarkxpress' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'qxd',
                    1 => 'qxt',
                    2 => 'qwd',
                    3 => 'qwt',
                    4 => 'qxl',
                    5 => 'qxb',
                ],
        ],
    'application/vnd.quobject-quoxdocument' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.moml+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-audit+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-audit-conf+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-audit-conn+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-audit-dialog+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-audit-stream+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-conf+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-dialog+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-dialog-base+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-dialog-fax-detect+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-dialog-fax-sendrecv+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-dialog-group+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-dialog-speech+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.radisys.msml-dialog-transform+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.rainstor.data' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.rapid' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.rar' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.realvnc.bed' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'bed',
                ],
        ],
    'application/vnd.recordare.musicxml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mxl',
                ],
        ],
    'application/vnd.recordare.musicxml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'musicxml',
                ],
        ],
    'application/vnd.renlearn.rlprint' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.rig.cryptonote' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cryptonote',
                ],
        ],
    'application/vnd.rim.cod' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cod',
                ],
        ],
    'application/vnd.rn-realmedia' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'rm',
                ],
        ],
    'application/vnd.rn-realmedia-vbr' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'rmvb',
                ],
        ],
    'application/vnd.route66.link66+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'link66',
                ],
        ],
    'application/vnd.rs-274x' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ruckus.download' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.s3sms' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sailingtracker.track' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'st',
                ],
        ],
    'application/vnd.sbm.cid' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sbm.mid2' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.scribus' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealed.3df' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealed.csf' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealed.doc' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealed.eml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealed.mht' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealed.net' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealed.ppt' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealed.tiff' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealed.xls' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealedmedia.softseal.html' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sealedmedia.softseal.pdf' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.seemail' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'see',
                ],
        ],
    'application/vnd.sema' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sema',
                ],
        ],
    'application/vnd.semd' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'semd',
                ],
        ],
    'application/vnd.semf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'semf',
                ],
        ],
    'application/vnd.shana.informed.formdata' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ifm',
                ],
        ],
    'application/vnd.shana.informed.formtemplate' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'itp',
                ],
        ],
    'application/vnd.shana.informed.interchange' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'iif',
                ],
        ],
    'application/vnd.shana.informed.package' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ipk',
                ],
        ],
    'application/vnd.sigrok.session' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.simtech-mindmapper' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'twd',
                    1 => 'twds',
                ],
        ],
    'application/vnd.siren+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.smaf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mmf',
                ],
        ],
    'application/vnd.smart.notebook' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.smart.teacher' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'teacher',
                ],
        ],
    'application/vnd.software602.filler.form+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.software602.filler.form-xml-zip' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.solent.sdkm+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sdkm',
                    1 => 'sdkd',
                ],
        ],
    'application/vnd.spotfire.dxp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dxp',
                ],
        ],
    'application/vnd.spotfire.sfs' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sfs',
                ],
        ],
    'application/vnd.sss-cod' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sss-dtf' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sss-ntf' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.stardivision.calc' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sdc',
                ],
        ],
    'application/vnd.stardivision.draw' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sda',
                ],
        ],
    'application/vnd.stardivision.impress' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sdd',
                ],
        ],
    'application/vnd.stardivision.math' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'smf',
                ],
        ],
    'application/vnd.stardivision.writer' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sdw',
                    1 => 'vor',
                ],
        ],
    'application/vnd.stardivision.writer-global' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sgl',
                ],
        ],
    'application/vnd.stepmania.package' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'smzip',
                ],
        ],
    'application/vnd.stepmania.stepchart' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sm',
                ],
        ],
    'application/vnd.street-stream' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.sun.wadl+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'wadl',
                ],
        ],
    'application/vnd.sun.xml.calc' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sxc',
                ],
        ],
    'application/vnd.sun.xml.calc.template' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'stc',
                ],
        ],
    'application/vnd.sun.xml.draw' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sxd',
                ],
        ],
    'application/vnd.sun.xml.draw.template' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'std',
                ],
        ],
    'application/vnd.sun.xml.impress' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sxi',
                ],
        ],
    'application/vnd.sun.xml.impress.template' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sti',
                ],
        ],
    'application/vnd.sun.xml.math' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sxm',
                ],
        ],
    'application/vnd.sun.xml.writer' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sxw',
                ],
        ],
    'application/vnd.sun.xml.writer.global' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sxg',
                ],
        ],
    'application/vnd.sun.xml.writer.template' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'stw',
                ],
        ],
    'application/vnd.sus-calendar' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sus',
                    1 => 'susp',
                ],
        ],
    'application/vnd.svd' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'svd',
                ],
        ],
    'application/vnd.swiftview-ics' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.symbian.install' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sis',
                    1 => 'sisx',
                ],
        ],
    'application/vnd.syncml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xsm',
                ],
        ],
    'application/vnd.syncml.dm+wbxml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'bdm',
                ],
        ],
    'application/vnd.syncml.dm+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xdm',
                ],
        ],
    'application/vnd.syncml.dm.notification' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.syncml.dmddf+wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.syncml.dmddf+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.syncml.dmtnds+wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.syncml.dmtnds+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.syncml.ds.notification' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.tableschema+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.tao.intent-module-archive' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'tao',
                ],
        ],
    'application/vnd.tcpdump.pcap' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pcap',
                    1 => 'cap',
                    2 => 'dmp',
                ],
        ],
    'application/vnd.tmd.mediaflex.api+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.tml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.tmobile-livetv' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'tmo',
                ],
        ],
    'application/vnd.tri.onesource' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.trid.tpt' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'tpt',
                ],
        ],
    'application/vnd.triscape.mxs' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mxs',
                ],
        ],
    'application/vnd.trueapp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'tra',
                ],
        ],
    'application/vnd.truedoc' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ubisoft.webplayer' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.ufdl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ufd',
                    1 => 'ufdl',
                ],
        ],
    'application/vnd.uiq.theme' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'utz',
                ],
        ],
    'application/vnd.umajin' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'umj',
                ],
        ],
    'application/vnd.unity' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'unityweb',
                ],
        ],
    'application/vnd.uoml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'uoml',
                ],
        ],
    'application/vnd.uplanet.alert' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.alert-wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.bearer-choice' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.bearer-choice-wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.cacheop' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.cacheop-wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.channel' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.channel-wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.list' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.list-wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.listcmd' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.listcmd-wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uplanet.signal' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.uri-map' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.valve.source.material' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.vcx' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'vcx',
                ],
        ],
    'application/vnd.vd-study' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.vectorworks' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.vel+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.verimatrix.vcas' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.vidsoft.vidconference' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.visio' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'vsd',
                    1 => 'vst',
                    2 => 'vss',
                    3 => 'vsw',
                ],
        ],
    'application/vnd.visionary' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'vis',
                ],
        ],
    'application/vnd.vividence.scriptfile' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.vsf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'vsf',
                ],
        ],
    'application/vnd.wap.sic' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wap.slc' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wap.wbxml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wbxml',
                ],
        ],
    'application/vnd.wap.wmlc' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wmlc',
                ],
        ],
    'application/vnd.wap.wmlscriptc' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wmlsc',
                ],
        ],
    'application/vnd.webturbo' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wtb',
                ],
        ],
    'application/vnd.wfa.p2p' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wfa.wsc' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.windows.devicepairing' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wmc' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wmf.bootstrap' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wolfram.mathematica' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wolfram.mathematica.package' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wolfram.player' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'nbp',
                ],
        ],
    'application/vnd.wordperfect' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wpd',
                ],
        ],
    'application/vnd.wqd' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wqd',
                ],
        ],
    'application/vnd.wrq-hp3000-labelled' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wt.stf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'stf',
                ],
        ],
    'application/vnd.wv.csp+wbxml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wv.csp+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.wv.ssp+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.xacml+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/vnd.xara' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xar',
                ],
        ],
    'application/vnd.xfdl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xfdl',
                ],
        ],
    'application/vnd.xfdl.webform' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.xmi+xml' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.xmpie.cpkg' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.xmpie.dpkg' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.xmpie.plan' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.xmpie.ppkg' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.xmpie.xlim' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.yamaha.hv-dic' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'hvd',
                ],
        ],
    'application/vnd.yamaha.hv-script' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'hvs',
                ],
        ],
    'application/vnd.yamaha.hv-voice' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'hvp',
                ],
        ],
    'application/vnd.yamaha.openscoreformat' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'osf',
                ],
        ],
    'application/vnd.yamaha.openscoreformat.osfpvg+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'osfpvg',
                ],
        ],
    'application/vnd.yamaha.remote-setup' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.yamaha.smaf-audio' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'saf',
                ],
        ],
    'application/vnd.yamaha.smaf-phrase' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'spf',
                ],
        ],
    'application/vnd.yamaha.through-ngn' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.yamaha.tunnel-udpencap' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.yaoweme' =>
        [
            'source' => 'iana',
        ],
    'application/vnd.yellowriver-custom-menu' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cmp',
                ],
        ],
    'application/vnd.zul' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'zir',
                    1 => 'zirz',
                ],
        ],
    'application/vnd.zzazz.deck+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'zaz',
                ],
        ],
    'application/voicexml+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'vxml',
                ],
        ],
    'application/vq-rtcpxr' =>
        [
            'source' => 'iana',
        ],
    'application/watcherinfo+xml' =>
        [
            'source' => 'iana',
        ],
    'application/whoispp-query' =>
        [
            'source' => 'iana',
        ],
    'application/whoispp-response' =>
        [
            'source' => 'iana',
        ],
    'application/widget' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wgt',
                ],
        ],
    'application/winhlp' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'hlp',
                ],
        ],
    'application/wita' =>
        [
            'source' => 'iana',
        ],
    'application/wordperfect5.1' =>
        [
            'source' => 'iana',
        ],
    'application/wsdl+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wsdl',
                ],
        ],
    'application/wspolicy+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wspolicy',
                ],
        ],
    'application/x-7z-compressed' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => '7z',
                ],
        ],
    'application/x-abiword' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'abw',
                ],
        ],
    'application/x-ace-compressed' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ace',
                ],
        ],
    'application/x-amf' =>
        [
            'source' => 'apache',
        ],
    'application/x-apple-diskimage' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'dmg',
                ],
        ],
    'application/x-authorware-bin' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'aab',
                    1 => 'x32',
                    2 => 'u32',
                    3 => 'vox',
                ],
        ],
    'application/x-authorware-map' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'aam',
                ],
        ],
    'application/x-authorware-seg' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'aas',
                ],
        ],
    'application/x-bcpio' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'bcpio',
                ],
        ],
    'application/x-bdoc' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'bdoc',
                ],
        ],
    'application/x-bittorrent' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'torrent',
                ],
        ],
    'application/x-blorb' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'blb',
                    1 => 'blorb',
                ],
        ],
    'application/x-bzip' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'bz',
                ],
        ],
    'application/x-bzip2' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'bz2',
                    1 => 'boz',
                ],
        ],
    'application/x-cbr' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cbr',
                    1 => 'cba',
                    2 => 'cbt',
                    3 => 'cbz',
                    4 => 'cb7',
                ],
        ],
    'application/x-cdlink' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'vcd',
                ],
        ],
    'application/x-cfs-compressed' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cfs',
                ],
        ],
    'application/x-chat' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'chat',
                ],
        ],
    'application/x-chess-pgn' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pgn',
                ],
        ],
    'application/x-chrome-extension' =>
        [
            'extensions' =>
                [
                    0 => 'crx',
                ],
        ],
    'application/x-cocoa' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'cco',
                ],
        ],
    'application/x-compress' =>
        [
            'source' => 'apache',
        ],
    'application/x-conference' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'nsc',
                ],
        ],
    'application/x-cpio' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cpio',
                ],
        ],
    'application/x-csh' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'csh',
                ],
        ],
    'application/x-deb' =>
        [
            'compressible' => false,
        ],
    'application/x-debian-package' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'deb',
                    1 => 'udeb',
                ],
        ],
    'application/x-dgc-compressed' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'dgc',
                ],
        ],
    'application/x-director' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'dir',
                    1 => 'dcr',
                    2 => 'dxr',
                    3 => 'cst',
                    4 => 'cct',
                    5 => 'cxt',
                    6 => 'w3d',
                    7 => 'fgd',
                    8 => 'swa',
                ],
        ],
    'application/x-doom' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wad',
                ],
        ],
    'application/x-dtbncx+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ncx',
                ],
        ],
    'application/x-dtbook+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'dtb',
                ],
        ],
    'application/x-dtbresource+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'res',
                ],
        ],
    'application/x-dvi' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'dvi',
                ],
        ],
    'application/x-envoy' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'evy',
                ],
        ],
    'application/x-eva' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'eva',
                ],
        ],
    'application/x-font-bdf' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'bdf',
                ],
        ],
    'application/x-font-dos' =>
        [
            'source' => 'apache',
        ],
    'application/x-font-framemaker' =>
        [
            'source' => 'apache',
        ],
    'application/x-font-ghostscript' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'gsf',
                ],
        ],
    'application/x-font-libgrx' =>
        [
            'source' => 'apache',
        ],
    'application/x-font-linux-psf' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'psf',
                ],
        ],
    'application/x-font-otf' =>
        [
            'source' => 'apache',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'otf',
                ],
        ],
    'application/x-font-pcf' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pcf',
                ],
        ],
    'application/x-font-snf' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'snf',
                ],
        ],
    'application/x-font-speedo' =>
        [
            'source' => 'apache',
        ],
    'application/x-font-sunos-news' =>
        [
            'source' => 'apache',
        ],
    'application/x-font-ttf' =>
        [
            'source' => 'apache',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'ttf',
                    1 => 'ttc',
                ],
        ],
    'application/x-font-type1' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pfa',
                    1 => 'pfb',
                    2 => 'pfm',
                    3 => 'afm',
                ],
        ],
    'application/x-font-vfont' =>
        [
            'source' => 'apache',
        ],
    'application/x-freearc' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'arc',
                ],
        ],
    'application/x-futuresplash' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'spl',
                ],
        ],
    'application/x-gca-compressed' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'gca',
                ],
        ],
    'application/x-glulx' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ulx',
                ],
        ],
    'application/x-gnumeric' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'gnumeric',
                ],
        ],
    'application/x-gramps-xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'gramps',
                ],
        ],
    'application/x-gtar' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'gtar',
                ],
        ],
    'application/x-gzip' =>
        [
            'source' => 'apache',
        ],
    'application/x-hdf' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'hdf',
                ],
        ],
    'application/x-httpd-php' =>
        [
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'php',
                ],
        ],
    'application/x-install-instructions' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'install',
                ],
        ],
    'application/x-iso9660-image' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'iso',
                ],
        ],
    'application/x-java-archive-diff' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'jardiff',
                ],
        ],
    'application/x-java-jnlp-file' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'jnlp',
                ],
        ],
    'application/x-javascript' =>
        [
            'compressible' => true,
        ],
    'application/x-latex' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'latex',
                ],
        ],
    'application/x-lua-bytecode' =>
        [
            'extensions' =>
                [
                    0 => 'luac',
                ],
        ],
    'application/x-lzh-compressed' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'lzh',
                    1 => 'lha',
                ],
        ],
    'application/x-makeself' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'run',
                ],
        ],
    'application/x-mie' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mie',
                ],
        ],
    'application/x-mobipocket-ebook' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'prc',
                    1 => 'mobi',
                ],
        ],
    'application/x-mpegurl' =>
        [
            'compressible' => false,
        ],
    'application/x-ms-application' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'application',
                ],
        ],
    'application/x-ms-shortcut' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'lnk',
                ],
        ],
    'application/x-ms-wmd' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wmd',
                ],
        ],
    'application/x-ms-wmz' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wmz',
                ],
        ],
    'application/x-ms-xbap' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xbap',
                ],
        ],
    'application/x-msaccess' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mdb',
                ],
        ],
    'application/x-msbinder' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'obd',
                ],
        ],
    'application/x-mscardfile' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'crd',
                ],
        ],
    'application/x-msclip' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'clp',
                ],
        ],
    'application/x-msdos-program' =>
        [
            'extensions' =>
                [
                    0 => 'exe',
                ],
        ],
    'application/x-msdownload' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'exe',
                    1 => 'dll',
                    2 => 'com',
                    3 => 'bat',
                    4 => 'msi',
                ],
        ],
    'application/x-msmediaview' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mvb',
                    1 => 'm13',
                    2 => 'm14',
                ],
        ],
    'application/x-msmetafile' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wmf',
                    1 => 'wmz',
                    2 => 'emf',
                    3 => 'emz',
                ],
        ],
    'application/x-msmoney' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mny',
                ],
        ],
    'application/x-mspublisher' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pub',
                ],
        ],
    'application/x-msschedule' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'scd',
                ],
        ],
    'application/x-msterminal' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'trm',
                ],
        ],
    'application/x-mswrite' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wri',
                ],
        ],
    'application/x-netcdf' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'nc',
                    1 => 'cdf',
                ],
        ],
    'application/x-ns-proxy-autoconfig' =>
        [
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'pac',
                ],
        ],
    'application/x-nzb' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'nzb',
                ],
        ],
    'application/x-perl' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'pl',
                    1 => 'pm',
                ],
        ],
    'application/x-pilot' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'prc',
                    1 => 'pdb',
                ],
        ],
    'application/x-pkcs12' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'p12',
                    1 => 'pfx',
                ],
        ],
    'application/x-pkcs7-certificates' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'p7b',
                    1 => 'spc',
                ],
        ],
    'application/x-pkcs7-certreqresp' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'p7r',
                ],
        ],
    'application/x-rar-compressed' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'rar',
                ],
        ],
    'application/x-redhat-package-manager' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'rpm',
                ],
        ],
    'application/x-research-info-systems' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ris',
                ],
        ],
    'application/x-sea' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'sea',
                ],
        ],
    'application/x-sh' =>
        [
            'source' => 'apache',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'sh',
                ],
        ],
    'application/x-shar' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'shar',
                ],
        ],
    'application/x-shockwave-flash' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'swf',
                ],
        ],
    'application/x-silverlight-app' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xap',
                ],
        ],
    'application/x-sql' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sql',
                ],
        ],
    'application/x-stuffit' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'sit',
                ],
        ],
    'application/x-stuffitx' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sitx',
                ],
        ],
    'application/x-subrip' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'srt',
                ],
        ],
    'application/x-sv4cpio' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sv4cpio',
                ],
        ],
    'application/x-sv4crc' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sv4crc',
                ],
        ],
    'application/x-t3vm-image' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 't3',
                ],
        ],
    'application/x-tads' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'gam',
                ],
        ],
    'application/x-tar' =>
        [
            'source' => 'apache',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'tar',
                ],
        ],
    'application/x-tcl' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'tcl',
                    1 => 'tk',
                ],
        ],
    'application/x-tex' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'tex',
                ],
        ],
    'application/x-tex-tfm' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'tfm',
                ],
        ],
    'application/x-texinfo' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'texinfo',
                    1 => 'texi',
                ],
        ],
    'application/x-tgif' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'obj',
                ],
        ],
    'application/x-ustar' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ustar',
                ],
        ],
    'application/x-wais-source' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'src',
                ],
        ],
    'application/x-web-app-manifest+json' =>
        [
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'webapp',
                ],
        ],
    'application/x-www-form-urlencoded' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/x-x509-ca-cert' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'der',
                    1 => 'crt',
                    2 => 'pem',
                ],
        ],
    'application/x-xfig' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'fig',
                ],
        ],
    'application/x-xliff+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xlf',
                ],
        ],
    'application/x-xpinstall' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'xpi',
                ],
        ],
    'application/x-xz' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xz',
                ],
        ],
    'application/x-zmachine' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'z1',
                    1 => 'z2',
                    2 => 'z3',
                    3 => 'z4',
                    4 => 'z5',
                    5 => 'z6',
                    6 => 'z7',
                    7 => 'z8',
                ],
        ],
    'application/x400-bp' =>
        [
            'source' => 'iana',
        ],
    'application/xacml+xml' =>
        [
            'source' => 'iana',
        ],
    'application/xaml+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xaml',
                ],
        ],
    'application/xcap-att+xml' =>
        [
            'source' => 'iana',
        ],
    'application/xcap-caps+xml' =>
        [
            'source' => 'iana',
        ],
    'application/xcap-diff+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xdf',
                ],
        ],
    'application/xcap-el+xml' =>
        [
            'source' => 'iana',
        ],
    'application/xcap-error+xml' =>
        [
            'source' => 'iana',
        ],
    'application/xcap-ns+xml' =>
        [
            'source' => 'iana',
        ],
    'application/xcon-conference-info+xml' =>
        [
            'source' => 'iana',
        ],
    'application/xcon-conference-info-diff+xml' =>
        [
            'source' => 'iana',
        ],
    'application/xenc+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xenc',
                ],
        ],
    'application/xhtml+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'xhtml',
                    1 => 'xht',
                ],
        ],
    'application/xhtml-voice+xml' =>
        [
            'source' => 'apache',
        ],
    'application/xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'xml',
                    1 => 'xsl',
                    2 => 'xsd',
                    3 => 'rng',
                ],
        ],
    'application/xml-dtd' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'dtd',
                ],
        ],
    'application/xml-external-parsed-entity' =>
        [
            'source' => 'iana',
        ],
    'application/xml-patch+xml' =>
        [
            'source' => 'iana',
        ],
    'application/xmpp+xml' =>
        [
            'source' => 'iana',
        ],
    'application/xop+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'xop',
                ],
        ],
    'application/xproc+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xpl',
                ],
        ],
    'application/xslt+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xslt',
                ],
        ],
    'application/xspf+xml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xspf',
                ],
        ],
    'application/xv+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mxml',
                    1 => 'xhvml',
                    2 => 'xvml',
                    3 => 'xvm',
                ],
        ],
    'application/yang' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'yang',
                ],
        ],
    'application/yang-data+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/yang-data+xml' =>
        [
            'source' => 'iana',
        ],
    'application/yang-patch+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'application/yang-patch+xml' =>
        [
            'source' => 'iana',
        ],
    'application/yin+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'yin',
                ],
        ],
    'application/zip' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'zip',
                ],
        ],
    'application/zlib' =>
        [
            'source' => 'iana',
        ],
    'audio/1d-interleaved-parityfec' =>
        [
            'source' => 'iana',
        ],
    'audio/32kadpcm' =>
        [
            'source' => 'iana',
        ],
    'audio/3gpp' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => '3gpp',
                ],
        ],
    'audio/3gpp2' =>
        [
            'source' => 'iana',
        ],
    'audio/ac3' =>
        [
            'source' => 'iana',
        ],
    'audio/adpcm' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'adp',
                ],
        ],
    'audio/amr' =>
        [
            'source' => 'iana',
        ],
    'audio/amr-wb' =>
        [
            'source' => 'iana',
        ],
    'audio/amr-wb+' =>
        [
            'source' => 'iana',
        ],
    'audio/aptx' =>
        [
            'source' => 'iana',
        ],
    'audio/asc' =>
        [
            'source' => 'iana',
        ],
    'audio/atrac-advanced-lossless' =>
        [
            'source' => 'iana',
        ],
    'audio/atrac-x' =>
        [
            'source' => 'iana',
        ],
    'audio/atrac3' =>
        [
            'source' => 'iana',
        ],
    'audio/basic' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'au',
                    1 => 'snd',
                ],
        ],
    'audio/bv16' =>
        [
            'source' => 'iana',
        ],
    'audio/bv32' =>
        [
            'source' => 'iana',
        ],
    'audio/clearmode' =>
        [
            'source' => 'iana',
        ],
    'audio/cn' =>
        [
            'source' => 'iana',
        ],
    'audio/dat12' =>
        [
            'source' => 'iana',
        ],
    'audio/dls' =>
        [
            'source' => 'iana',
        ],
    'audio/dsr-es201108' =>
        [
            'source' => 'iana',
        ],
    'audio/dsr-es202050' =>
        [
            'source' => 'iana',
        ],
    'audio/dsr-es202211' =>
        [
            'source' => 'iana',
        ],
    'audio/dsr-es202212' =>
        [
            'source' => 'iana',
        ],
    'audio/dv' =>
        [
            'source' => 'iana',
        ],
    'audio/dvi4' =>
        [
            'source' => 'iana',
        ],
    'audio/eac3' =>
        [
            'source' => 'iana',
        ],
    'audio/encaprtp' =>
        [
            'source' => 'iana',
        ],
    'audio/evrc' =>
        [
            'source' => 'iana',
        ],
    'audio/evrc-qcp' =>
        [
            'source' => 'iana',
        ],
    'audio/evrc0' =>
        [
            'source' => 'iana',
        ],
    'audio/evrc1' =>
        [
            'source' => 'iana',
        ],
    'audio/evrcb' =>
        [
            'source' => 'iana',
        ],
    'audio/evrcb0' =>
        [
            'source' => 'iana',
        ],
    'audio/evrcb1' =>
        [
            'source' => 'iana',
        ],
    'audio/evrcnw' =>
        [
            'source' => 'iana',
        ],
    'audio/evrcnw0' =>
        [
            'source' => 'iana',
        ],
    'audio/evrcnw1' =>
        [
            'source' => 'iana',
        ],
    'audio/evrcwb' =>
        [
            'source' => 'iana',
        ],
    'audio/evrcwb0' =>
        [
            'source' => 'iana',
        ],
    'audio/evrcwb1' =>
        [
            'source' => 'iana',
        ],
    'audio/evs' =>
        [
            'source' => 'iana',
        ],
    'audio/fwdred' =>
        [
            'source' => 'iana',
        ],
    'audio/g711-0' =>
        [
            'source' => 'iana',
        ],
    'audio/g719' =>
        [
            'source' => 'iana',
        ],
    'audio/g722' =>
        [
            'source' => 'iana',
        ],
    'audio/g7221' =>
        [
            'source' => 'iana',
        ],
    'audio/g723' =>
        [
            'source' => 'iana',
        ],
    'audio/g726-16' =>
        [
            'source' => 'iana',
        ],
    'audio/g726-24' =>
        [
            'source' => 'iana',
        ],
    'audio/g726-32' =>
        [
            'source' => 'iana',
        ],
    'audio/g726-40' =>
        [
            'source' => 'iana',
        ],
    'audio/g728' =>
        [
            'source' => 'iana',
        ],
    'audio/g729' =>
        [
            'source' => 'iana',
        ],
    'audio/g7291' =>
        [
            'source' => 'iana',
        ],
    'audio/g729d' =>
        [
            'source' => 'iana',
        ],
    'audio/g729e' =>
        [
            'source' => 'iana',
        ],
    'audio/gsm' =>
        [
            'source' => 'iana',
        ],
    'audio/gsm-efr' =>
        [
            'source' => 'iana',
        ],
    'audio/gsm-hr-08' =>
        [
            'source' => 'iana',
        ],
    'audio/ilbc' =>
        [
            'source' => 'iana',
        ],
    'audio/ip-mr_v2.5' =>
        [
            'source' => 'iana',
        ],
    'audio/isac' =>
        [
            'source' => 'apache',
        ],
    'audio/l16' =>
        [
            'source' => 'iana',
        ],
    'audio/l20' =>
        [
            'source' => 'iana',
        ],
    'audio/l24' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'audio/l8' =>
        [
            'source' => 'iana',
        ],
    'audio/lpc' =>
        [
            'source' => 'iana',
        ],
    'audio/melp' =>
        [
            'source' => 'iana',
        ],
    'audio/melp1200' =>
        [
            'source' => 'iana',
        ],
    'audio/melp2400' =>
        [
            'source' => 'iana',
        ],
    'audio/melp600' =>
        [
            'source' => 'iana',
        ],
    'audio/midi' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mid',
                    1 => 'midi',
                    2 => 'kar',
                    3 => 'rmi',
                ],
        ],
    'audio/mobile-xmf' =>
        [
            'source' => 'iana',
        ],
    'audio/mp3' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'mp3',
                ],
        ],
    'audio/mp4' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'm4a',
                    1 => 'mp4a',
                ],
        ],
    'audio/mp4a-latm' =>
        [
            'source' => 'iana',
        ],
    'audio/mpa' =>
        [
            'source' => 'iana',
        ],
    'audio/mpa-robust' =>
        [
            'source' => 'iana',
        ],
    'audio/mpeg' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'mpga',
                    1 => 'mp2',
                    2 => 'mp2a',
                    3 => 'mp3',
                    4 => 'm2a',
                    5 => 'm3a',
                ],
        ],
    'audio/mpeg4-generic' =>
        [
            'source' => 'iana',
        ],
    'audio/musepack' =>
        [
            'source' => 'apache',
        ],
    'audio/ogg' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'oga',
                    1 => 'ogg',
                    2 => 'spx',
                ],
        ],
    'audio/opus' =>
        [
            'source' => 'iana',
        ],
    'audio/parityfec' =>
        [
            'source' => 'iana',
        ],
    'audio/pcma' =>
        [
            'source' => 'iana',
        ],
    'audio/pcma-wb' =>
        [
            'source' => 'iana',
        ],
    'audio/pcmu' =>
        [
            'source' => 'iana',
        ],
    'audio/pcmu-wb' =>
        [
            'source' => 'iana',
        ],
    'audio/prs.sid' =>
        [
            'source' => 'iana',
        ],
    'audio/qcelp' =>
        [
            'source' => 'iana',
        ],
    'audio/raptorfec' =>
        [
            'source' => 'iana',
        ],
    'audio/red' =>
        [
            'source' => 'iana',
        ],
    'audio/rtp-enc-aescm128' =>
        [
            'source' => 'iana',
        ],
    'audio/rtp-midi' =>
        [
            'source' => 'iana',
        ],
    'audio/rtploopback' =>
        [
            'source' => 'iana',
        ],
    'audio/rtx' =>
        [
            'source' => 'iana',
        ],
    'audio/s3m' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 's3m',
                ],
        ],
    'audio/silk' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sil',
                ],
        ],
    'audio/smv' =>
        [
            'source' => 'iana',
        ],
    'audio/smv-qcp' =>
        [
            'source' => 'iana',
        ],
    'audio/smv0' =>
        [
            'source' => 'iana',
        ],
    'audio/sp-midi' =>
        [
            'source' => 'iana',
        ],
    'audio/speex' =>
        [
            'source' => 'iana',
        ],
    'audio/t140c' =>
        [
            'source' => 'iana',
        ],
    'audio/t38' =>
        [
            'source' => 'iana',
        ],
    'audio/telephone-event' =>
        [
            'source' => 'iana',
        ],
    'audio/tone' =>
        [
            'source' => 'iana',
        ],
    'audio/uemclip' =>
        [
            'source' => 'iana',
        ],
    'audio/ulpfec' =>
        [
            'source' => 'iana',
        ],
    'audio/vdvi' =>
        [
            'source' => 'iana',
        ],
    'audio/vmr-wb' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.3gpp.iufp' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.4sb' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.audiokoz' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.celp' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.cisco.nse' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.cmles.radio-events' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.cns.anp1' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.cns.inf1' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.dece.audio' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'uva',
                    1 => 'uvva',
                ],
        ],
    'audio/vnd.digital-winds' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'eol',
                ],
        ],
    'audio/vnd.dlna.adts' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.dolby.heaac.1' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.dolby.heaac.2' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.dolby.mlp' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.dolby.mps' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.dolby.pl2' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.dolby.pl2x' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.dolby.pl2z' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.dolby.pulse.1' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.dra' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dra',
                ],
        ],
    'audio/vnd.dts' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dts',
                ],
        ],
    'audio/vnd.dts.hd' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dtshd',
                ],
        ],
    'audio/vnd.dvb.file' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.everad.plj' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.hns.audio' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.lucent.voice' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'lvp',
                ],
        ],
    'audio/vnd.ms-playready.media.pya' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'pya',
                ],
        ],
    'audio/vnd.nokia.mobile-xmf' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.nortel.vbk' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.nuera.ecelp4800' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ecelp4800',
                ],
        ],
    'audio/vnd.nuera.ecelp7470' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ecelp7470',
                ],
        ],
    'audio/vnd.nuera.ecelp9600' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ecelp9600',
                ],
        ],
    'audio/vnd.octel.sbc' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.qcelp' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.rhetorex.32kadpcm' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.rip' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rip',
                ],
        ],
    'audio/vnd.rn-realaudio' =>
        [
            'compressible' => false,
        ],
    'audio/vnd.sealedmedia.softseal.mpeg' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.vmx.cvsd' =>
        [
            'source' => 'iana',
        ],
    'audio/vnd.wave' =>
        [
            'compressible' => false,
        ],
    'audio/vorbis' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'audio/vorbis-config' =>
        [
            'source' => 'iana',
        ],
    'audio/wav' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'wav',
                ],
        ],
    'audio/wave' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'wav',
                ],
        ],
    'audio/webm' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'weba',
                ],
        ],
    'audio/x-aac' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'aac',
                ],
        ],
    'audio/x-aiff' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'aif',
                    1 => 'aiff',
                    2 => 'aifc',
                ],
        ],
    'audio/x-caf' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'caf',
                ],
        ],
    'audio/x-flac' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'flac',
                ],
        ],
    'audio/x-m4a' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'm4a',
                ],
        ],
    'audio/x-matroska' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mka',
                ],
        ],
    'audio/x-mpegurl' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'm3u',
                ],
        ],
    'audio/x-ms-wax' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wax',
                ],
        ],
    'audio/x-ms-wma' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wma',
                ],
        ],
    'audio/x-pn-realaudio' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ram',
                    1 => 'ra',
                ],
        ],
    'audio/x-pn-realaudio-plugin' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'rmp',
                ],
        ],
    'audio/x-realaudio' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'ra',
                ],
        ],
    'audio/x-tta' =>
        [
            'source' => 'apache',
        ],
    'audio/x-wav' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wav',
                ],
        ],
    'audio/xm' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xm',
                ],
        ],
    'chemical/x-cdx' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cdx',
                ],
        ],
    'chemical/x-cif' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cif',
                ],
        ],
    'chemical/x-cmdf' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cmdf',
                ],
        ],
    'chemical/x-cml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cml',
                ],
        ],
    'chemical/x-csml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'csml',
                ],
        ],
    'chemical/x-pdb' =>
        [
            'source' => 'apache',
        ],
    'chemical/x-xyz' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xyz',
                ],
        ],
    'font/opentype' =>
        [
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'otf',
                ],
        ],
    'image/apng' =>
        [
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'apng',
                ],
        ],
    'image/bmp' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'bmp',
                ],
        ],
    'image/cgm' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'cgm',
                ],
        ],
    'image/dicom-rle' =>
        [
            'source' => 'iana',
        ],
    'image/emf' =>
        [
            'source' => 'iana',
        ],
    'image/fits' =>
        [
            'source' => 'iana',
        ],
    'image/g3fax' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'g3',
                ],
        ],
    'image/gif' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'gif',
                ],
        ],
    'image/ief' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ief',
                ],
        ],
    'image/jls' =>
        [
            'source' => 'iana',
        ],
    'image/jp2' =>
        [
            'source' => 'iana',
        ],
    'image/jpeg' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'jpeg',
                    1 => 'jpg',
                    2 => 'jpe',
                ],
        ],
    'image/jpm' =>
        [
            'source' => 'iana',
        ],
    'image/jpx' =>
        [
            'source' => 'iana',
        ],
    'image/ktx' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ktx',
                ],
        ],
    'image/naplps' =>
        [
            'source' => 'iana',
        ],
    'image/pjpeg' =>
        [
            'compressible' => false,
        ],
    'image/png' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'png',
                ],
        ],
    'image/prs.btif' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'btif',
                ],
        ],
    'image/prs.pti' =>
        [
            'source' => 'iana',
        ],
    'image/pwg-raster' =>
        [
            'source' => 'iana',
        ],
    'image/sgi' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sgi',
                ],
        ],
    'image/svg+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'svg',
                    1 => 'svgz',
                ],
        ],
    'image/t38' =>
        [
            'source' => 'iana',
        ],
    'image/tiff' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'tiff',
                    1 => 'tif',
                ],
        ],
    'image/tiff-fx' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.adobe.photoshop' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'psd',
                ],
        ],
    'image/vnd.airzip.accelerator.azv' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.cns.inf2' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.dece.graphic' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'uvi',
                    1 => 'uvvi',
                    2 => 'uvg',
                    3 => 'uvvg',
                ],
        ],
    'image/vnd.djvu' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'djvu',
                    1 => 'djv',
                ],
        ],
    'image/vnd.dvb.subtitle' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sub',
                ],
        ],
    'image/vnd.dwg' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dwg',
                ],
        ],
    'image/vnd.dxf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dxf',
                ],
        ],
    'image/vnd.fastbidsheet' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fbs',
                ],
        ],
    'image/vnd.fpx' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fpx',
                ],
        ],
    'image/vnd.fst' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fst',
                ],
        ],
    'image/vnd.fujixerox.edmics-mmr' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mmr',
                ],
        ],
    'image/vnd.fujixerox.edmics-rlc' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'rlc',
                ],
        ],
    'image/vnd.globalgraphics.pgb' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.microsoft.icon' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.mix' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.mozilla.apng' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.ms-modi' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mdi',
                ],
        ],
    'image/vnd.ms-photo' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wdp',
                ],
        ],
    'image/vnd.net-fpx' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'npx',
                ],
        ],
    'image/vnd.radiance' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.sealed.png' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.sealedmedia.softseal.gif' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.sealedmedia.softseal.jpg' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.svf' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.tencent.tap' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.valve.source.texture' =>
        [
            'source' => 'iana',
        ],
    'image/vnd.wap.wbmp' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wbmp',
                ],
        ],
    'image/vnd.xiff' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'xif',
                ],
        ],
    'image/vnd.zbrush.pcx' =>
        [
            'source' => 'iana',
        ],
    'image/webp' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'webp',
                ],
        ],
    'image/wmf' =>
        [
            'source' => 'iana',
        ],
    'image/x-3ds' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => '3ds',
                ],
        ],
    'image/x-cmu-raster' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ras',
                ],
        ],
    'image/x-cmx' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'cmx',
                ],
        ],
    'image/x-freehand' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'fh',
                    1 => 'fhc',
                    2 => 'fh4',
                    3 => 'fh5',
                    4 => 'fh7',
                ],
        ],
    'image/x-icon' =>
        [
            'source' => 'apache',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'ico',
                ],
        ],
    'image/x-jng' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'jng',
                ],
        ],
    'image/x-mrsid-image' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sid',
                ],
        ],
    'image/x-ms-bmp' =>
        [
            'source' => 'nginx',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'bmp',
                ],
        ],
    'image/x-pcx' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pcx',
                ],
        ],
    'image/x-pict' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pic',
                    1 => 'pct',
                ],
        ],
    'image/x-portable-anymap' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pnm',
                ],
        ],
    'image/x-portable-bitmap' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pbm',
                ],
        ],
    'image/x-portable-graymap' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pgm',
                ],
        ],
    'image/x-portable-pixmap' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ppm',
                ],
        ],
    'image/x-rgb' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'rgb',
                ],
        ],
    'image/x-tga' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'tga',
                ],
        ],
    'image/x-xbitmap' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xbm',
                ],
        ],
    'image/x-xcf' =>
        [
            'compressible' => false,
        ],
    'image/x-xpixmap' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xpm',
                ],
        ],
    'image/x-xwindowdump' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'xwd',
                ],
        ],
    'message/cpim' =>
        [
            'source' => 'iana',
        ],
    'message/delivery-status' =>
        [
            'source' => 'iana',
        ],
    'message/disposition-notification' =>
        [
            'source' => 'iana',
        ],
    'message/external-body' =>
        [
            'source' => 'iana',
        ],
    'message/feedback-report' =>
        [
            'source' => 'iana',
        ],
    'message/global' =>
        [
            'source' => 'iana',
        ],
    'message/global-delivery-status' =>
        [
            'source' => 'iana',
        ],
    'message/global-disposition-notification' =>
        [
            'source' => 'iana',
        ],
    'message/global-headers' =>
        [
            'source' => 'iana',
        ],
    'message/http' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'message/imdn+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'message/news' =>
        [
            'source' => 'iana',
        ],
    'message/partial' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'message/rfc822' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'eml',
                    1 => 'mime',
                ],
        ],
    'message/s-http' =>
        [
            'source' => 'iana',
        ],
    'message/sip' =>
        [
            'source' => 'iana',
        ],
    'message/sipfrag' =>
        [
            'source' => 'iana',
        ],
    'message/tracking-status' =>
        [
            'source' => 'iana',
        ],
    'message/vnd.si.simp' =>
        [
            'source' => 'iana',
        ],
    'message/vnd.wfa.wsc' =>
        [
            'source' => 'iana',
        ],
    'model/3mf' =>
        [
            'source' => 'iana',
        ],
    'model/gltf+json' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'model/iges' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'igs',
                    1 => 'iges',
                ],
        ],
    'model/mesh' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'msh',
                    1 => 'mesh',
                    2 => 'silo',
                ],
        ],
    'model/vnd.collada+xml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dae',
                ],
        ],
    'model/vnd.dwf' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dwf',
                ],
        ],
    'model/vnd.flatland.3dml' =>
        [
            'source' => 'iana',
        ],
    'model/vnd.gdl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gdl',
                ],
        ],
    'model/vnd.gs-gdl' =>
        [
            'source' => 'apache',
        ],
    'model/vnd.gs.gdl' =>
        [
            'source' => 'iana',
        ],
    'model/vnd.gtw' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gtw',
                ],
        ],
    'model/vnd.moml+xml' =>
        [
            'source' => 'iana',
        ],
    'model/vnd.mts' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'mts',
                ],
        ],
    'model/vnd.opengex' =>
        [
            'source' => 'iana',
        ],
    'model/vnd.parasolid.transmit.binary' =>
        [
            'source' => 'iana',
        ],
    'model/vnd.parasolid.transmit.text' =>
        [
            'source' => 'iana',
        ],
    'model/vnd.rosette.annotated-data-model' =>
        [
            'source' => 'iana',
        ],
    'model/vnd.valve.source.compiled-map' =>
        [
            'source' => 'iana',
        ],
    'model/vnd.vtu' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'vtu',
                ],
        ],
    'model/vrml' =>
        [
            'source' => 'iana',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'wrl',
                    1 => 'vrml',
                ],
        ],
    'model/x3d+binary' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'x3db',
                    1 => 'x3dbz',
                ],
        ],
    'model/x3d+fastinfoset' =>
        [
            'source' => 'iana',
        ],
    'model/x3d+vrml' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'x3dv',
                    1 => 'x3dvz',
                ],
        ],
    'model/x3d+xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'x3d',
                    1 => 'x3dz',
                ],
        ],
    'model/x3d-vrml' =>
        [
            'source' => 'iana',
        ],
    'multipart/alternative' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'multipart/appledouble' =>
        [
            'source' => 'iana',
        ],
    'multipart/byteranges' =>
        [
            'source' => 'iana',
        ],
    'multipart/digest' =>
        [
            'source' => 'iana',
        ],
    'multipart/encrypted' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'multipart/form-data' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'multipart/header-set' =>
        [
            'source' => 'iana',
        ],
    'multipart/mixed' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'multipart/parallel' =>
        [
            'source' => 'iana',
        ],
    'multipart/related' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'multipart/report' =>
        [
            'source' => 'iana',
        ],
    'multipart/signed' =>
        [
            'source' => 'iana',
            'compressible' => false,
        ],
    'multipart/vnd.bint.med-plus' =>
        [
            'source' => 'iana',
        ],
    'multipart/voice-message' =>
        [
            'source' => 'iana',
        ],
    'multipart/x-mixed-replace' =>
        [
            'source' => 'iana',
        ],
    'text/1d-interleaved-parityfec' =>
        [
            'source' => 'iana',
        ],
    'text/cache-manifest' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'appcache',
                    1 => 'manifest',
                ],
        ],
    'text/calendar' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ics',
                    1 => 'ifb',
                ],
        ],
    'text/calender' =>
        [
            'compressible' => true,
        ],
    'text/cmd' =>
        [
            'compressible' => true,
        ],
    'text/coffeescript' =>
        [
            'extensions' =>
                [
                    0 => 'coffee',
                    1 => 'litcoffee',
                ],
        ],
    'text/css' =>
        [
            'source' => 'iana',
            'charset' => 'UTF-8',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'css',
                ],
        ],
    'text/csv' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'csv',
                ],
        ],
    'text/csv-schema' =>
        [
            'source' => 'iana',
        ],
    'text/directory' =>
        [
            'source' => 'iana',
        ],
    'text/dns' =>
        [
            'source' => 'iana',
        ],
    'text/ecmascript' =>
        [
            'source' => 'iana',
        ],
    'text/encaprtp' =>
        [
            'source' => 'iana',
        ],
    'text/enriched' =>
        [
            'source' => 'iana',
        ],
    'text/fwdred' =>
        [
            'source' => 'iana',
        ],
    'text/grammar-ref-list' =>
        [
            'source' => 'iana',
        ],
    'text/hjson' =>
        [
            'extensions' =>
                [
                    0 => 'hjson',
                ],
        ],
    'text/html' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'html',
                    1 => 'htm',
                    2 => 'shtml',
                ],
        ],
    'text/jade' =>
        [
            'extensions' =>
                [
                    0 => 'jade',
                ],
        ],
    'text/javascript' =>
        [
            'source' => 'iana',
            'compressible' => true,
        ],
    'text/jcr-cnd' =>
        [
            'source' => 'iana',
        ],
    'text/jsx' =>
        [
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'jsx',
                ],
        ],
    'text/less' =>
        [
            'extensions' =>
                [
                    0 => 'less',
                ],
        ],
    'text/markdown' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'markdown',
                    1 => 'md',
                ],
        ],
    'text/mathml' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'mml',
                ],
        ],
    'text/mizar' =>
        [
            'source' => 'iana',
        ],
    'text/n3' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'n3',
                ],
        ],
    'text/parameters' =>
        [
            'source' => 'iana',
        ],
    'text/parityfec' =>
        [
            'source' => 'iana',
        ],
    'text/plain' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'txt',
                    1 => 'text',
                    2 => 'conf',
                    3 => 'def',
                    4 => 'list',
                    5 => 'log',
                    6 => 'in',
                    7 => 'ini',
                ],
        ],
    'text/provenance-notation' =>
        [
            'source' => 'iana',
        ],
    'text/prs.fallenstein.rst' =>
        [
            'source' => 'iana',
        ],
    'text/prs.lines.tag' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'dsc',
                ],
        ],
    'text/prs.prop.logic' =>
        [
            'source' => 'iana',
        ],
    'text/raptorfec' =>
        [
            'source' => 'iana',
        ],
    'text/red' =>
        [
            'source' => 'iana',
        ],
    'text/rfc822-headers' =>
        [
            'source' => 'iana',
        ],
    'text/richtext' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'rtx',
                ],
        ],
    'text/rtf' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'rtf',
                ],
        ],
    'text/rtp-enc-aescm128' =>
        [
            'source' => 'iana',
        ],
    'text/rtploopback' =>
        [
            'source' => 'iana',
        ],
    'text/rtx' =>
        [
            'source' => 'iana',
        ],
    'text/sgml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sgml',
                    1 => 'sgm',
                ],
        ],
    'text/slim' =>
        [
            'extensions' =>
                [
                    0 => 'slim',
                    1 => 'slm',
                ],
        ],
    'text/strings' =>
        [
            'source' => 'iana',
        ],
    'text/stylus' =>
        [
            'extensions' =>
                [
                    0 => 'stylus',
                    1 => 'styl',
                ],
        ],
    'text/t140' =>
        [
            'source' => 'iana',
        ],
    'text/tab-separated-values' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'tsv',
                ],
        ],
    'text/troff' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 't',
                    1 => 'tr',
                    2 => 'roff',
                    3 => 'man',
                    4 => 'me',
                    5 => 'ms',
                ],
        ],
    'text/turtle' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'ttl',
                ],
        ],
    'text/ulpfec' =>
        [
            'source' => 'iana',
        ],
    'text/uri-list' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'uri',
                    1 => 'uris',
                    2 => 'urls',
                ],
        ],
    'text/vcard' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'vcard',
                ],
        ],
    'text/vnd.a' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.abc' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.ascii-art' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.curl' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'curl',
                ],
        ],
    'text/vnd.curl.dcurl' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'dcurl',
                ],
        ],
    'text/vnd.curl.mcurl' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mcurl',
                ],
        ],
    'text/vnd.curl.scurl' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'scurl',
                ],
        ],
    'text/vnd.debian.copyright' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.dmclientscript' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.dvb.subtitle' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'sub',
                ],
        ],
    'text/vnd.esmertec.theme-descriptor' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.fly' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'fly',
                ],
        ],
    'text/vnd.fmi.flexstor' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'flx',
                ],
        ],
    'text/vnd.graphviz' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'gv',
                ],
        ],
    'text/vnd.in3d.3dml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => '3dml',
                ],
        ],
    'text/vnd.in3d.spot' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'spot',
                ],
        ],
    'text/vnd.iptc.newsml' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.iptc.nitf' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.latex-z' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.motorola.reflex' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.ms-mediapackage' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.net2phone.commcenter.command' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.radisys.msml-basic-layout' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.si.uricatalogue' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.sun.j2me.app-descriptor' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'jad',
                ],
        ],
    'text/vnd.trolltech.linguist' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.wap.si' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.wap.sl' =>
        [
            'source' => 'iana',
        ],
    'text/vnd.wap.wml' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wml',
                ],
        ],
    'text/vnd.wap.wmlscript' =>
        [
            'source' => 'iana',
            'extensions' =>
                [
                    0 => 'wmls',
                ],
        ],
    'text/vtt' =>
        [
            'charset' => 'UTF-8',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'vtt',
                ],
        ],
    'text/x-asm' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 's',
                    1 => 'asm',
                ],
        ],
    'text/x-c' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'c',
                    1 => 'cc',
                    2 => 'cxx',
                    3 => 'cpp',
                    4 => 'h',
                    5 => 'hh',
                    6 => 'dic',
                ],
        ],
    'text/x-component' =>
        [
            'source' => 'nginx',
            'extensions' =>
                [
                    0 => 'htc',
                ],
        ],
    'text/x-fortran' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'f',
                    1 => 'for',
                    2 => 'f77',
                    3 => 'f90',
                ],
        ],
    'text/x-gwt-rpc' =>
        [
            'compressible' => true,
        ],
    'text/x-handlebars-template' =>
        [
            'extensions' =>
                [
                    0 => 'hbs',
                ],
        ],
    'text/x-java-source' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'java',
                ],
        ],
    'text/x-jquery-tmpl' =>
        [
            'compressible' => true,
        ],
    'text/x-lua' =>
        [
            'extensions' =>
                [
                    0 => 'lua',
                ],
        ],
    'text/x-markdown' =>
        [
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'mkd',
                ],
        ],
    'text/x-nfo' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'nfo',
                ],
        ],
    'text/x-opml' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'opml',
                ],
        ],
    'text/x-pascal' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'p',
                    1 => 'pas',
                ],
        ],
    'text/x-processing' =>
        [
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'pde',
                ],
        ],
    'text/x-sass' =>
        [
            'extensions' =>
                [
                    0 => 'sass',
                ],
        ],
    'text/x-scss' =>
        [
            'extensions' =>
                [
                    0 => 'scss',
                ],
        ],
    'text/x-setext' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'etx',
                ],
        ],
    'text/x-sfv' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'sfv',
                ],
        ],
    'text/x-suse-ymp' =>
        [
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'ymp',
                ],
        ],
    'text/x-uuencode' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'uu',
                ],
        ],
    'text/x-vcalendar' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'vcs',
                ],
        ],
    'text/x-vcard' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'vcf',
                ],
        ],
    'text/xml' =>
        [
            'source' => 'iana',
            'compressible' => true,
            'extensions' =>
                [
                    0 => 'xml',
                ],
        ],
    'text/xml-external-parsed-entity' =>
        [
            'source' => 'iana',
        ],
    'text/yaml' =>
        [
            'extensions' =>
                [
                    0 => 'yaml',
                    1 => 'yml',
                ],
        ],
    'video/1d-interleaved-parityfec' =>
        [
            'source' => 'apache',
        ],
    'video/3gpp' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => '3gp',
                    1 => '3gpp',
                ],
        ],
    'video/3gpp-tt' =>
        [
            'source' => 'apache',
        ],
    'video/3gpp2' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => '3g2',
                ],
        ],
    'video/bmpeg' =>
        [
            'source' => 'apache',
        ],
    'video/bt656' =>
        [
            'source' => 'apache',
        ],
    'video/celb' =>
        [
            'source' => 'apache',
        ],
    'video/dv' =>
        [
            'source' => 'apache',
        ],
    'video/encaprtp' =>
        [
            'source' => 'apache',
        ],
    'video/h261' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'h261',
                ],
        ],
    'video/h263' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'h263',
                ],
        ],
    'video/h263-1998' =>
        [
            'source' => 'apache',
        ],
    'video/h263-2000' =>
        [
            'source' => 'apache',
        ],
    'video/h264' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'h264',
                ],
        ],
    'video/h264-rcdo' =>
        [
            'source' => 'apache',
        ],
    'video/h264-svc' =>
        [
            'source' => 'apache',
        ],
    'video/h265' =>
        [
            'source' => 'apache',
        ],
    'video/iso.segment' =>
        [
            'source' => 'apache',
        ],
    'video/jpeg' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'jpgv',
                ],
        ],
    'video/jpeg2000' =>
        [
            'source' => 'apache',
        ],
    'video/jpm' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'jpm',
                    1 => 'jpgm',
                ],
        ],
    'video/mj2' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mj2',
                    1 => 'mjp2',
                ],
        ],
    'video/mp1s' =>
        [
            'source' => 'apache',
        ],
    'video/mp2p' =>
        [
            'source' => 'apache',
        ],
    'video/mp2t' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ts',
                ],
        ],
    'video/mp4' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'mp4',
                    1 => 'mp4v',
                    2 => 'mpg4',
                ],
        ],
    'video/mp4v-es' =>
        [
            'source' => 'apache',
        ],
    'video/mpeg' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'mpeg',
                    1 => 'mpg',
                    2 => 'mpe',
                    3 => 'm1v',
                    4 => 'm2v',
                ],
        ],
    'video/mpeg4-generic' =>
        [
            'source' => 'apache',
        ],
    'video/mpv' =>
        [
            'source' => 'apache',
        ],
    'video/nv' =>
        [
            'source' => 'apache',
        ],
    'video/ogg' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'ogv',
                ],
        ],
    'video/parityfec' =>
        [
            'source' => 'apache',
        ],
    'video/pointer' =>
        [
            'source' => 'apache',
        ],
    'video/quicktime' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'qt',
                    1 => 'mov',
                ],
        ],
    'video/raptorfec' =>
        [
            'source' => 'apache',
        ],
    'video/raw' =>
        [
            'source' => 'apache',
        ],
    'video/rtp-enc-aescm128' =>
        [
            'source' => 'apache',
        ],
    'video/rtploopback' =>
        [
            'source' => 'apache',
        ],
    'video/rtx' =>
        [
            'source' => 'apache',
        ],
    'video/smpte292m' =>
        [
            'source' => 'apache',
        ],
    'video/ulpfec' =>
        [
            'source' => 'apache',
        ],
    'video/vc1' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.cctv' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.dece.hd' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'uvh',
                    1 => 'uvvh',
                ],
        ],
    'video/vnd.dece.mobile' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'uvm',
                    1 => 'uvvm',
                ],
        ],
    'video/vnd.dece.mp4' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.dece.pd' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'uvp',
                    1 => 'uvvp',
                ],
        ],
    'video/vnd.dece.sd' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'uvs',
                    1 => 'uvvs',
                ],
        ],
    'video/vnd.dece.video' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'uvv',
                    1 => 'uvvv',
                ],
        ],
    'video/vnd.directv.mpeg' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.directv.mpeg-tts' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.dlna.mpeg-tts' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.dvb.file' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'dvb',
                ],
        ],
    'video/vnd.fvt' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'fvt',
                ],
        ],
    'video/vnd.hns.video' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.iptvforum.1dparityfec-1010' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.iptvforum.1dparityfec-2005' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.iptvforum.2dparityfec-1010' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.iptvforum.2dparityfec-2005' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.iptvforum.ttsavc' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.iptvforum.ttsmpeg2' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.motorola.video' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.motorola.videop' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.mpegurl' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mxu',
                    1 => 'm4u',
                ],
        ],
    'video/vnd.ms-playready.media.pyv' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'pyv',
                ],
        ],
    'video/vnd.nokia.interleaved-multimedia' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.nokia.videovoip' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.objectvideo' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.radgamettools.bink' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.radgamettools.smacker' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.sealed.mpeg1' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.sealed.mpeg4' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.sealed.swf' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.sealedmedia.softseal.mov' =>
        [
            'source' => 'apache',
        ],
    'video/vnd.uvvu.mp4' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'uvu',
                    1 => 'uvvu',
                ],
        ],
    'video/vnd.vivo' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'viv',
                ],
        ],
    'video/vp8' =>
        [
            'source' => 'apache',
        ],
    'video/webm' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'webm',
                ],
        ],
    'video/x-f4v' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'f4v',
                ],
        ],
    'video/x-fli' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'fli',
                ],
        ],
    'video/x-flv' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'flv',
                ],
        ],
    'video/x-m4v' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'm4v',
                ],
        ],
    'video/x-matroska' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'mkv',
                    1 => 'mk3d',
                    2 => 'mks',
                ],
        ],
    'video/x-mng' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'mng',
                ],
        ],
    'video/x-ms-asf' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'asf',
                    1 => 'asx',
                ],
        ],
    'video/x-ms-vob' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'vob',
                ],
        ],
    'video/x-ms-wm' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wm',
                ],
        ],
    'video/x-ms-wmv' =>
        [
            'source' => 'apache',
            'compressible' => false,
            'extensions' =>
                [
                    0 => 'wmv',
                ],
        ],
    'video/x-ms-wmx' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wmx',
                ],
        ],
    'video/x-ms-wvx' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'wvx',
                ],
        ],
    'video/x-msvideo' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'avi',
                ],
        ],
    'video/x-sgi-movie' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'movie',
                ],
        ],
    'video/x-smv' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'smv',
                ],
        ],
    'x-conference/x-cooltalk' =>
        [
            'source' => 'apache',
            'extensions' =>
                [
                    0 => 'ice',
                ],
        ],
    'x-shader/x-fragment' =>
        [
            'compressible' => true,
        ],
    'x-shader/x-vertex' =>
        [
            'compressible' => true,
        ],
];