<?php

namespace Disjfa\MailBundle\Command;

use Disjfa\MailBundle\Mail\MailCollection;
use Disjfa\MailBundle\Mail\MailFactory;
use Disjfa\MailBundle\Mail\MailService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class PreviewMail extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'disjfa:mail:preview-mail';
    /**
     * @var MailCollection
     */
    private $mailCollection;
    /**
     * @var MailFactory
     */
    private $mailFactory;
    /**
     * @var MailService
     */
    private $mailService;

    /**
     * PreviewMail constructor.
     */
    public function __construct(MailCollection $mailCollection, MailFactory $mailFactory, MailService $mailService)
    {
        parent::__construct(static::$defaultName);

        $this->mailCollection = $mailCollection;
        $this->mailFactory = $mailFactory;
        $this->mailService = $mailService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Preview an email.')
            ->setHelp('This command allows you to preview and email in the system');
    }

    /**
     * @return int|void|null
     *
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $emails = [];
        foreach ($this->mailCollection->getMails() as $mail) {
            $emails[] = $mail->getName();
        }

        $question = new ChoiceQuestion(
            'Please select an email',
            $emails
        );

        $name = $helper->ask($input, $output, $question);
        $mail = $this->mailFactory->findByName($name);

        $question = new ChoiceQuestion(
            'What to do?',
            ['preview', 'preview raw', 'send email'],
            0
        );

        $todo = $helper->ask($input, $output, $question);
        if ('preview' === $todo) {
            $output->write($mail->getContent());

            return;
        }

        $mailParameters = $mail->getParameters();
        if (empty($mailParameters)) {
            $output->writeln('No parameters found');
        }

        $parameters = [];
        foreach ($mailParameters as $parameter) {
            $question = new Question('Parameter: "'.$parameter.'"? ', '##'.$parameter.'##');

            $parameters[$parameter] = $helper->ask($input, $output, $question);
        }

        if ('preview raw' === $todo) {
            $email = $this->mailService->create($mail, $parameters);
            $output->write($email->getHtmlBody());

            return;
        }

        if ('send email' === $todo) {
            $question = new Question('Select email adress to send to? ');
            $to = $helper->ask($input, $output, $question);

            $this->mailService->send($mail, $parameters, $to);
            $output->writeln('<info>Email sent to '.$to.'</info>');

            return;
        }
    }
}
