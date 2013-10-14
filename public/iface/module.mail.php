<?php
/**
 * Module Mail
 * Модуль для отправки писем
 * @author Alexey iP Subbota
 * @version 0.1
 */

class module_mail
{
  /**
   * отправляем письмо
   * @param string to - адрес получателя
   * @param string title - тема письма
   * @param string text - тело письма
   * @result integer - результат выполнения функции mail
   */
  public function sendMail($to, $title, $text)
  {
    global $m_core;

    $header  = "From: ip@ip-studios.ru\n";

    $header .= "To: ' . $to . '\n";
    $header .= "Subject: ' . $title . '\n";
    $header .= "X-Mailer: PHPMail Tool\n";
    $header .= "Reply-To: ip@ip-studios.ru\n";
    $header .= "Mime-Version: 1.0\n";
    $header .= "Content-Type:text/plain; charset=utf-8;";

    return mail($to, $title, $text, $header);
  }

  public function __construct()
  {
  }
}
