<?php
function error($msg)
{
    echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"><script type=\'text/javascript\'>
                
                            const notyf = new Notyf();
                            notyf
                              .error({
                                message: \'' . $msg . '\',
                                duration: 3500,
                                dismissible: true
                              });               
                
                </script>';
}

function success($msg)
{
    echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"><script type=\'text/javascript\'>
                
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'' . $msg . '\',
                                duration: 3500,
                                dismissible: true
                              });               
                
                </script>';
}
?>