<?php
session_start();
if(!isset($_SESSION['id']) && !isset($_SESSION['curProx']) && !isset($_SESSION['visibility'.$_SESSION['curProx']])){
    header('location: ./login.php');
}
include("../config/dbconfig.php");
include("../config/constant.php");

$testTable = $_SESSION['handle'];
function compileC($code, $input){
    putenv("PATH=C:\MinGW\bin");
    $out="a.exe";
    $CC = "gcc";
    $filename_code="main.c";
    $filename_in="input.txt";
    $filename_error="error.txt";
    $executable="a.exe";
    $command=$CC." -lm ".$filename_code;
    $command_error=$command." 2>".$filename_error;

    $file_code=fopen($filename_code,"w+");
    fwrite($file_code,$code);
    fclose($file_code);
    $file_in=fopen($filename_in,"w+");
    fwrite($file_in,$input);
    fclose($file_in);
    exec("cacls  $executable /g everyone:f");
    exec("cacls  $filename_error /g everyone:f");

    shell_exec($command_error);
    $error=file_get_contents($filename_error);
    if(trim($error)=="") {
        if(trim($input)=="") {
            $output=shell_exec($out);
        }
        else {
            $out=$out." < ".$filename_in;
            $output=shell_exec($out);
        }
        exec("del $filename_code");
        exec("del *.o");
        exec("del *.txt");
        exec("del $executable");
        return $output;
    }
    else if(!strpos($error,"error")) {
        $output = "<pre>$error</pre>";
        if(trim($input)=="") {
            $output.=shell_exec($out);
        }
        else {
            $out=$out." < ".$filename_in;
            $output.=shell_exec($out);
        }
        exec("del $filename_code");
        exec("del *.o");
        exec("del *.txt");
        exec("del $executable");
        return $output;
    }
    else {
        exec("del $filename_code");
        exec("del *.o");
        exec("del *.txt");
        exec("del $executable");
        return "<pre>$error</pre>";
    }

}
function compileCpp($code, $input){
    putenv("PATH=C:\MinGW\bin");
    $out="a.exe";
    $CC = "g++";
    $filename_code="main.cpp";
    $filename_in="input.txt";
    $filename_error="error.txt";
    $executable="a.exe";
    $command=$CC." -lm ".$filename_code;
    $command_error=$command." 2>".$filename_error;

    $file_code=fopen($filename_code,"w+");
    fwrite($file_code,$code);
    fclose($file_code);
    $file_in=fopen($filename_in,"w+");
    fwrite($file_in,$input);
    fclose($file_in);
    exec("cacls  $executable /g everyone:f");
    exec("cacls  $filename_error /g everyone:f");

    shell_exec($command_error);
    $error=file_get_contents($filename_error);
    if(trim($error)=="") {
        if(trim($input)=="") {
            $output=shell_exec($out);
        }
        else {
            $out=$out." < ".$filename_in;
            $output=shell_exec($out);
        }
        exec("del $filename_code");
        exec("del *.o");
        exec("del *.txt");
        exec("del $executable");
        return $output;
    }
    else if(!strpos($error,"error")) {
        $output = "<pre>$error</pre>";
        if(trim($input)=="") {
            $output.=shell_exec($out);
        }
        else {
            $out=$out." < ".$filename_in;
            $output.=shell_exec($out);
        }
        exec("del $filename_code");
        exec("del *.o");
        exec("del *.txt");
        exec("del $executable");
        return $output;
    }
    else {
        exec("del $filename_code");
        exec("del *.o");
        exec("del *.txt");
        exec("del $executable");
        return "<pre>$error</pre>";
    }

}

function compileJava($classname, $code, $input){
    putenv("PATH=C:\Program Files\Java\jdk-18.0.1.1\bin");
    $CC = "javac";
    $out = "java ".$classname;
    $filename_code = $classname.".java";
    $filename_in = "input.txt";
    $filename_error = "error.txt";
    $runtime_file = "runtime.txt";
    $executable = "*.class";
    $command = $CC . " " . $filename_code;
    $command_error = $command . " 2>" . $filename_error;
    $runtime_error_command = $out . " 2>" . $runtime_file;

    $file_code = fopen($filename_code, "w+");
    fwrite($file_code, $code);
    fclose($file_code);
    $file_in = fopen($filename_in, "w+");
    fwrite($file_in, $input);
    fclose($file_in);
    exec("cacls  $executable /g everyone:f");
    exec("cacls  $filename_error /g everyone:f");

    shell_exec($command_error);
    $error = file_get_contents($filename_error);

    if (trim($error) == "") {
        if (trim($input) == "") {
            shell_exec($runtime_error_command);
            $runtime_error = file_get_contents($runtime_file);
            $output = shell_exec($out);
        } else {
            shell_exec($runtime_error_command);
            $runtime_error = file_get_contents($runtime_file);
            $out = $out . " < " . $filename_in;
            $output = shell_exec($out);
        }
        exec("del $filename_code");
        exec("del *.txt");
        exec("del $executable");
        return $output;
    } else if (!strpos($error, "error")) {
        echo "<pre>$error</pre>";
        if (trim($input) == "") {
            $output = shell_exec($out);
        } else {
            $out = $out . " < " . $filename_in;
            $output = shell_exec($out);
        }
        exec("del $filename_code");
        exec("del *.txt");
        exec("del $executable");
        return $output;
    } else {
        exec("del $filename_code");
        exec("del *.txt");
        exec("del $executable");
        return "<pre>$error</pre>";
    }
}

if (isset($_POST['submitCode'])){
    $lang = $_POST['lang'];
    $code = $_POST['editor'];
    $message = "";
    $stmt = $conn->prepare("SELECT * from `$testTable`");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $input = data_decrypt($row['input'], $_SESSION['iv']);
        $output = data_decrypt($row['output'], $_SESSION['iv']);
        if ($lang =='c'){
            $cOutput = compileC($code, $input);
            if (strpos($cOutput, 'error')!==false){
                $message = "Compilation error";
                break;
            }
            else{
                $output = strtolower($output);
                $cOutput = strtolower($cOutput);
                if (trim($cOutput) != trim($output)){
                    $message = "Wrong answer on test ".$id;
                    break;
                }
                else{
                    $message = "Accepted";
                }
            }
        }
        else if ($lang =='cpp'){
            $cOutput = compileCpp($code, $input);
            if (strpos($cOutput, 'error')!==false){
                $message = "Compilation error";
                break;
            }
            else{
                $output = strtolower($output);
                $cOutput = strtolower($cOutput);
                if (trim($cOutput) != trim($output)){
                    $message = "Wrong answer on test ".$id;
                    break;
                }
                else{
                    $message = "Accepted";
                }
            }
        }

        else if ($lang == 'java'){
            $regex = '/[^{}]*public\s+(final)?\s*class\s+(\w+).*/';
            if (preg_match($regex, $code)) {
                $pattern = '/public\s+class\s+(\w+)\s*\{/';
                preg_match($pattern, $code, $matches);
                $className = $matches[1];
                $cOutput = compileJava($className, $code, $input);
                if (strpos($cOutput, 'error')!==false){
                    $message = "Compilation error";
                    break;
                }
                else{
                    $output = strtolower($output);
                    $cOutput = strtolower($cOutput);
                    if (trim($cOutput) != trim($output)){
                        $message = "Wrong answer on test ".$id;
                        break;
                    }
                    else{
                        $message = "Accepted";
                    }
                }
            }
            else {
                $message = "Main class should be public";
                break;
            }
        }
    }
    $unique_id = uniqid();
    $submission_ID = data_encrypt(substr($unique_id, -10), $_SESSION['iv']);
    $submitted_BY = $_SESSION['id'];
    $problem = data_encrypt($_SESSION['name'.$_SESSION['curProx']], $_SESSION['iv']);
    $code = data_encrypt($code, $_SESSION['iv']);
    $lang = data_encrypt($lang, $_SESSION['iv']);
    $verdict = data_encrypt($message, $_SESSION['iv']);
    $iv = bin2hex($_SESSION['iv']);
//    echo $submission_ID."<br>".$submitted_BY."<br>".$code."<br>".$lang."<br>".$verdict."<br>".$iv." ".$_SESSION['name'.$_SESSION['curProx']];
    $stmt = $conn->prepare("INSERT INTO submissions (submission_id, submitted_by,problem_id, problem, code, language, verdict, iv) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssss", $submission_ID, $submitted_BY,$_SESSION['curProx'], $problem, $code, $lang, $verdict, $iv);
    $stmt->execute();
    $stmt->close();
    header('location: ../mySubmission.php');
}
