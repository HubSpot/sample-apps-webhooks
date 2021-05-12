class EventsController < ApplicationController
  before_action :authorize

  def index
    @events = Event.all
  end

  def not_shown_count
    render json: { count: Event.where('created_at > ?', params[:time_mark].to_datetime).count }
  end

  private

  def authorize
    unless authorized?
      redirect_to login_path and return unless Token.any?

      session['tokens'] = Token.instance.attributes
    end

    session['tokens'] = Services::Hubspot::Authorization::Tokens::Refresh.new(tokens: session['tokens'], request: request).call
    Services::Hubspot::Authorization::Authorize.new(tokens: session['tokens']).call
  end
end